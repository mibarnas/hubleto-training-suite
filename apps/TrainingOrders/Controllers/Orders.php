<?php

namespace Hubleto\App\External\TrainingSuite\TrainingOrders\Controllers;

use Hubleto\App\External\TrainingSuite\TrainingOrders\Onboarding;
use Hubleto\App\External\TrainingSuite\Common\Onboarding as OnboardingService;

class Orders extends \Hubleto\Erp\Controller
{

  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => 'training-orders', 'content' => $this->translate('Training orders') ],
    ]);
  }

  public function prepareView(): void
  {
    parent::prepareView();

    /** @var OnboardingService */
    $onboarding = $this->getService(OnboardingService::class);
    $this->viewParams['onboarding'] = $onboarding->getViewParams($this, Onboarding::KEY);

    $this->setView('@Hubleto:App:External:TrainingSuite:TrainingOrders/Orders.twig');
  }

}
