import App from '@hubleto/react-ui/core/App'

import TableQuestionnaires from "./Components/TableQuestionnaires"
import FormQuestionnaire from "./Components/FormQuestionnaire"
import InputTimestamp from "../Trainings/Components/InputTimestamp"
import OnboardingGuide from "../Common/Components/OnboardingGuide"
import registerDictionary from "../Common/Dictionary"
import sk from "./Lang/sk.json"

class QuestionnairesApp extends App {
  init() {
    super.init();
    registerDictionary('Hubleto\\App\\External\\TrainingSuite\\Questionnaires\\Loader', { sk });

    // Shared by all four custom apps; whichever loads first wins, so no app
    // has to depend on another having loaded. Same arrangement as InputTimestamp.
    globalThis.hubleto.registerReactComponent('OnboardingGuide', OnboardingGuide);

    // Registered from every app that uses it: whichever loads first wins, and
    // the questionnaire form must not depend on Trainings having loaded.
    globalThis.hubleto.registerReactComponent('InputTimestamp', InputTimestamp);
    globalThis.hubleto.registerReactComponent('QuestionnairesTableQuestionnaires', TableQuestionnaires);
    globalThis.hubleto.registerReactComponent('QuestionnairesFormQuestionnaire', FormQuestionnaire);
  }
}

globalThis.hubleto.registerApp('Hubleto/App/External/TrainingSuite/Questionnaires', new QuestionnairesApp());
