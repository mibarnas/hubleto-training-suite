<?php

namespace Hubleto\App\External\TrainingSuite\Trainings\Controllers;

use Hubleto\App\External\TrainingSuite\Trainings\Onboarding;
use Hubleto\App\External\TrainingSuite\Common\Onboarding as OnboardingService;

class Trainings extends \Hubleto\Erp\Controller
{

  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => 'trainings', 'content' => $this->translate('Trainings') ],
    ]);
  }

  public function prepareView(): void
  {
    parent::prepareView();

    /** @var OnboardingService */
    $onboarding = $this->getService(OnboardingService::class);
    $this->viewParams['onboarding'] = $onboarding->getViewParams($this, Onboarding::KEY);

    $this->setView('@Hubleto:App:External:TrainingSuite:Trainings/Trainings.twig');
  }

}
