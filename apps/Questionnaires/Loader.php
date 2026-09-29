<?php

namespace Hubleto\App\External\TrainingSuite\Questionnaires;

class Loader extends \Hubleto\Erp\App
{

  public function init(): void
  {
    parent::init();

    \Hubleto\App\External\TrainingSuite\Common\Translations::register($this);

    $this->router()->get([
      '/^questionnaires\/api\/onboarding-seen\/?$/' => \Hubleto\App\External\TrainingSuite\Common\Controllers\OnboardingSeen::class,
      '/^questionnaires(\/(?<recordId>\d+))?\/?$/' => Controllers\Questionnaires::class,
    ]);
  }

  public function installApp(int $round): void
  {
    if ($round == 1) {
      $this->getModel(Models\Questionnaire::class)->upgradeSchema();
    }
  }

  public function generateDemoData(): void
  {
  }

}
