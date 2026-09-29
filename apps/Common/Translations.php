<?php

namespace Hubleto\App\External\TrainingSuite\Common;

/**
 * Loads an app's own dictionaries (`<app>/Lang/<language>.json`) into the
 * translator.
 *
 * The stock translator only reads `vendor/hubleto/erp/lang`, so an app that
 * lives in its own package has nowhere to put its translations. Every app of
 * this package calls register() from its Loader::init() instead; nothing has
 * to be configured in the host project. The dictionaries of this Common folder
 * (used by the onboarding plumbing) are registered along with the first app.
 *
 * The browser gets the same files through Dictionary.ts.
 */
class Translations
{
  /** Translation context of the classes in this Common folder. */
  const COMMON_CONTEXT = 'hubleto-app-external-trainingsuite-common-loader';

  public static function register(\Hubleto\Framework\App $app): void
  {
    $translator = $app->translator();

    // A host may have swapped the translator for one that is not built on
    // the stock class; the apps then simply stay untranslated.
    if (!$translator instanceof \Hubleto\Framework\Translator) return;

    self::loadFolder($translator, $app->srcFolder . '/Lang', $app->translationContext);
    self::loadFolder($translator, __DIR__ . '/Lang', self::COMMON_CONTEXT);
  }

  private static function loadFolder(\Hubleto\Framework\Translator $translator, string $folder, string $context): void
  {
    foreach (glob($folder . '/*.json') ?: [] as $file) {
      $language = basename($file, '.json');

      // Translator::loadDictionary() skips a context that is already filled,
      // so what is put here is what the translator uses.
      if (!empty($translator->dictionary[$language][$context])) continue;

      $translator->dictionary[$language][$context] = (array) json_decode((string) file_get_contents($file), true);
    }
  }
}
