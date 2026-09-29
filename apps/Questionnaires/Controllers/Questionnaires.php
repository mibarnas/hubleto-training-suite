<?php

namespace Hubleto\App\External\TrainingSuite\Questionnaires\Controllers;

use Hubleto\App\External\TrainingSuite\Questionnaires\Onboarding;
use Hubleto\App\External\TrainingSuite\Common\Onboarding as OnboardingService;

class Questionnaires extends \Hubleto\Erp\Controller
{
  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => 'questionnaires', 'content' => $this->translate('Questionnaires') ],
    ]);
  }

  public function prepareView(): void
  {
    parent::prepareView();

    /** @var OnboardingService */
    $onboarding = $this->getService(OnboardingService::class);
    $this->viewParams['onboarding'] = $onboarding->getViewParams($this, Onboarding::KEY);

    $this->setView('@Hubleto:App:External:TrainingSuite:Questionnaires/Questionnaires.twig');
  }
}
