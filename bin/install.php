<?php

/**
 * Installs the Training Suite apps into the Hubleto project it is run from:
 *
 *   php vendor/algocorp/hubleto-training-suite/bin/install.php
 *
 * `php hubleto app install` only runs the first install round, which creates
 * the tables. This also runs the third one -- default permissions, their
 * assignment to roles, and foreign keys -- once every app's tables exist,
 * because the foreign keys point across apps. Apps that are already
 * installed are left alone, so running it twice is harmless.
 */

if (php_sapi_name() !== 'cli') exit(1);

$projectFolder = (string) getcwd();

if (!is_file($projectFolder . '/ConfigEnv.php') || !is_file($projectFolder . '/vendor/autoload.php')) {
  fwrite(STDERR, "Run this from the root folder of a Hubleto project (ConfigEnv.php or vendor/ not found).\n");
  exit(1);
}

// Same bootstrap as the `hubleto` CLI script.
$config = [];
require $projectFolder . '/ConfigEnv.php';
$config['projectFolder'] = $projectFolder;
require_once $projectFolder . '/vendor/autoload.php';
$config['sessionSalt'] = 'hubleto-cli-agent';

$hubleto = new \Hubleto\Erp\Loader($config);
$hubleto->init();

// In dependency order: every app requires the ones listed before it.
const APPS = [
  'Hubleto\App\External\TrainingSuite\Workers',
  'Hubleto\App\External\TrainingSuite\Trainings',
  'Hubleto\App\External\TrainingSuite\Questionnaires',
  'Hubleto\App\External\TrainingSuite\TrainingOrders',
];

$appManager = $hubleto->appManager();
$newlyInstalled = [];

try {
  foreach (APPS as $appNamespace) {
    if ($appManager->isAppInstalled($appNamespace)) {
      echo "{$appNamespace}: already installed, skipped\n";
      continue;
    }

    // Also installs any community app from the manifest's `requires` that is missing.
    $appManager->installApp(1, $appNamespace);
    $newlyInstalled[] = $appNamespace;
    echo "{$appNamespace}: tables created\n";
  }

  foreach ($newlyInstalled as $appNamespace) {
    $app = $appManager->createAppInstance($appNamespace);
    $app->installDefaultPermissions();
    $app->assignPermissionsToRoles();
    $app->migrateForeignKeys();
    echo "{$appNamespace}: permissions and foreign keys installed\n";
  }
} catch (\Throwable $e) {
  fwrite(STDERR, "Installation failed: " . $e->getMessage() . "\n");
  exit(1);
}

echo "Done.\n";
