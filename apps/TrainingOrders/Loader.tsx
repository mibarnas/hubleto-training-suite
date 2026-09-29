import App from '@hubleto/react-ui/core/App'

import TableOrders from "./Components/TableOrders"
import FormOrder from "./Components/FormOrder"
import OnboardingGuide from "../Common/Components/OnboardingGuide"
import registerDictionary from "../Common/Dictionary"
import sk from "./Lang/sk.json"

class TrainingOrdersApp extends App {
  init() {
    super.init();
    registerDictionary('Hubleto\\App\\External\\TrainingSuite\\TrainingOrders\\Loader', { sk });

    // Shared by all four custom apps; whichever loads first wins, so no app
    // has to depend on another having loaded. Same arrangement as InputTimestamp.
    globalThis.hubleto.registerReactComponent('OnboardingGuide', OnboardingGuide);

    // Prefixed with the app name: the community Orders app registers
    // `OrdersTableOrders`, and the two were overwriting each other in the
    // global component registry.
    globalThis.hubleto.registerReactComponent('TrainingOrdersTableOrders', TableOrders);
    globalThis.hubleto.registerReactComponent('TrainingOrdersFormOrder', FormOrder);
  }
}

globalThis.hubleto.registerApp('Hubleto/App/External/TrainingSuite/TrainingOrders', new TrainingOrdersApp());
