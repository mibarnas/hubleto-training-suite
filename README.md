# Training Suite for Hubleto

Training management for Hubleto ERP, packaged as external apps:

| App | Namespace | URL |
|---|---|---|
| Workers | `Hubleto\App\External\TrainingSuite\Workers` | `workers` |
| Trainings | `Hubleto\App\External\TrainingSuite\Trainings` | `trainings` |
| Questionnaires | `Hubleto\App\External\TrainingSuite\Questionnaires` | `questionnaires` |
| Training orders | `Hubleto\App\External\TrainingSuite\TrainingOrders` | `training-orders` |

`apps/Common` is not an app. It holds code the apps share: the migration base class, the onboarding guide, and the dictionary loaders.

## Requirements

- Hubleto ERP 1.1, built with the standard project webpack and Tailwind setup (`composer create-project hubleto/erp-project`).
- PHP 8.2+ with the `zip` extension.
- Installed community apps: Auth, Settings, Customers, Contacts, Calendar, Mail, Notifications and Documents. A standard Hubleto installation already has them; the installer adds any that are missing.
- Optional: LibreOffice (`soffice`) on the server, to produce certificates as PDF instead of .docx.

## Installation

All commands run from the root of the Hubleto project.

1. **Copy the package** into the project, for example to `packages/training-suite/`, so that this README is at `packages/training-suite/README.md`.

2. **Install it with Composer:**

   ```bash
   composer config repositories.training-suite path packages/training-suite
   composer require "algocorp/hubleto-training-suite:^1.0"
   ```

   Hubleto discovers the apps through Composer, so copying the folder alone is not enough.

3. **Add the apps to the frontend build.** In `webpack.config.js`, add one line to the `main` entry, next to the existing `findHubletoAppsInRepository(...)` lines:

   ```js
   ...findHubletoAppsInRepository(path.resolve(__dirname, 'vendor/algocorp/hubleto-training-suite/apps')),
   ```

   In `src/Main.twcss`, add this after the existing `@import` lines:

   ```css
   @import "../vendor/algocorp/hubleto-training-suite/apps/Common/styles.twcss";
   ```

   Then rebuild:

   ```bash
   npm run build
   ```

   Hubleto only loads the compiled bundles in `assets/compiled`, and an external app cannot add its own scripts, so this step can't be skipped.

4. **Install the apps into the database:**

   ```bash
   php vendor/algocorp/hubleto-training-suite/bin/install.php
   ```

   Use this rather than `php hubleto app install`. The CLI command only creates the tables; the installer also sets up permissions and foreign keys. It skips apps that are already installed, so running it again is safe.

After step 4 the apps appear in the sidebar. Users may need to log in again before new permissions take effect.

## Translations

Each app ships its dictionaries in `apps/<App>/Lang/<language>.json`, and the shared strings are in `apps/Common/Lang/`. The apps load them at runtime, on the server and in the browser, so the host project needs no translator configuration. Slovak (`sk`) is included.

To add a language, add `<language>.json` next to `sk.json` in each `Lang` folder. Then import it in the app's `Loader.tsx` and in `Common/Dictionary.ts` (for example `import de from "./Lang/de.json"` and `{ sk, de }`), and rebuild.

## Optional hardening: uploaded files

The Workers app serves uploaded files to signed-in users at `<projectUrl>/file/<path>`. To stop people downloading uploads directly without logging in, block the upload folder and point Hubleto at that route instead:

- `upload/.htaccess`: `Require all denied`
- `ConfigEnv.php`: `$config['uploadUrl'] = '<projectUrl>/file';`

## Updating

Replace the package folder, then run:

```bash
composer update algocorp/hubleto-training-suite
npm run build
php hubleto migrate
```

Schema changes are shipped as migrations (`Models/Migrations/<Model>_000N.php`), and `php hubleto migrate` applies them.
