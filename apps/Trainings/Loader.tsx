import App from '@hubleto/react-ui/core/App'

import TableTrainings from "./Components/TableTrainings"
import FormTraining from "./Components/FormTraining"
import TableSchedules from "./Components/TableSchedules"
import FormSchedule from "./Components/FormSchedule"
import TableAttendees from "./Components/TableAttendees"
import FormAttendee from "./Components/FormAttendee"
import TableCertificates from "./Components/TableCertificates"
import FormCertificate from "./Components/FormCertificate"
import InputTimestamp from "./Components/InputTimestamp"
import OnboardingGuide from "../Common/Components/OnboardingGuide"
import registerDictionary from "../Common/Dictionary"
import sk from "./Lang/sk.json"

class TrainingsApp extends App {
  init() {
    super.init();
    registerDictionary('Hubleto\\App\\External\\TrainingSuite\\Trainings\\Loader', { sk });


    // Shared by all four custom apps; whichever loads first wins, so no app
    // has to depend on another having loaded. Same arrangement as InputTimestamp.
    globalThis.hubleto.registerReactComponent('OnboardingGuide', OnboardingGuide);

    // Replacement for the stock datetime input; selected per column with
    // `setReactComponent('InputTimestamp')`.
    globalThis.hubleto.registerReactComponent('InputTimestamp', InputTimestamp);

    globalThis.hubleto.registerReactComponent('TrainingsTableTrainings', TableTrainings);
    globalThis.hubleto.registerReactComponent('TrainingsFormTraining', FormTraining);
    globalThis.hubleto.registerReactComponent('TrainingsTableSchedules', TableSchedules);
    globalThis.hubleto.registerReactComponent('TrainingsFormSchedule', FormSchedule);
    globalThis.hubleto.registerReactComponent('TrainingsTableAttendees', TableAttendees);
    globalThis.hubleto.registerReactComponent('TrainingsFormAttendee', FormAttendee);
    globalThis.hubleto.registerReactComponent('TrainingsTableCertificates', TableCertificates);
    globalThis.hubleto.registerReactComponent('TrainingsFormCertificate', FormCertificate);
  }
}

globalThis.hubleto.registerApp('Hubleto/App/External/TrainingSuite/Trainings', new TrainingsApp());
