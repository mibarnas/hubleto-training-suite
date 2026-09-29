// Browser-side counterpart of Translations.php: merges an app's own
// dictionaries into the one the Desktop page handed over, which only covers
// the dictionaries shipped with hubleto/erp.

import commonSk from './Lang/sk.json'

type Dictionaries = { [language: string]: any };

const COMMON_CONTEXT = 'Hubleto\\App\\External\\TrainingSuite\\Common\\Loader';
const COMMON_DICTIONARIES: Dictionaries = { sk: commonSk };

function merge(context: string, dictionaries: Dictionaries) {
  const hubleto = globalThis.hubleto;
  const dictionary = dictionaries[hubleto.language];
  if (!dictionary) return;

  // Same key Main.translate() looks the context up by.
  const key = context.replaceAll('\\', '-').toLowerCase();

  if (!hubleto.dictionary) hubleto.dictionary = {};
  hubleto.dictionary[key] = { ...(hubleto.dictionary[key] ?? {}), ...dictionary };
}

export default function registerDictionary(context: string, dictionaries: Dictionaries) {
  merge(context, dictionaries);
  merge(COMMON_CONTEXT, COMMON_DICTIONARIES);
}
