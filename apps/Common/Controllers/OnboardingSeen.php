<?php

namespace Hubleto\App\External\TrainingSuite\Common\Controllers;

use Hubleto\App\External\TrainingSuite\Common\Onboarding;

/**
 * Records that the signed-in user has dismissed an app's first-run guide.
 *
 * One controller for all apps; each app routes its own `<slug>/api/onboarding-seen`
 * to it and the guide it means travels in the request.
 */
class OnboardingSeen extends \Hubleto\Erp\Controllers\ApiController
{
  public function response(): array
  {
    $guide = $this->router()->urlParamAsString('guide');

    /** @var Onboarding */
    $onboarding = $this->getService(Onboarding::class);
    if (!$onboarding->exists($guide)) {
      throw new \Exception($this->translate('Unknown onboarding guide.'));
    }

    $onboarding->markAsSeen($guide);

    return ['status' => 'success'];
  }
}
