import App from '@hubleto/react-ui/core/App'

import TableWorkers from "./Components/TableWorkers"
import FormWorker from "./Components/FormWorker"
import OnboardingGuide from "../Common/Components/OnboardingGuide"
import registerDictionary from "../Common/Dictionary"
import sk from "./Lang/sk.json"

class WorkersApp extends App {
  init() {
    super.init();
    registerDictionary('Hubleto\\App\\External\\TrainingSuite\\Workers\\Loader', { sk });

    // Shared by all four custom apps; whichever loads first wins, so no app
    // has to depend on another having loaded. Same arrangement as InputTimestamp.
    globalThis.hubleto.registerReactComponent('OnboardingGuide', OnboardingGuide);

    globalThis.hubleto.registerReactComponent('WorkersTableWorkers', TableWorkers);
    globalThis.hubleto.registerReactComponent('WorkersFormWorker', FormWorker);
  }
}

globalThis.hubleto.registerApp('Hubleto/App/External/TrainingSuite/Workers', new WorkersApp());
