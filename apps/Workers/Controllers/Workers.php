<?php

namespace Hubleto\App\External\TrainingSuite\Workers\Controllers;

use Hubleto\App\External\TrainingSuite\Workers\Onboarding;
use Hubleto\App\External\TrainingSuite\Common\Onboarding as OnboardingService;

class Workers extends \Hubleto\Erp\Controller
{

  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => 'workers', 'content' => $this->translate('Workers') ],
    ]);
  }

  public function prepareView(): void
  {
    parent::prepareView();

    /** @var OnboardingService */
    $onboarding = $this->getService(OnboardingService::class);
    $this->viewParams['onboarding'] = $onboarding->getViewParams($this, Onboarding::KEY);

    $this->setView('@Hubleto:App:External:TrainingSuite:Workers/Workers.twig');
  }

}
