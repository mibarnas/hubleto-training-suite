<?php

namespace Hubleto\App\External\TrainingSuite\Workers\Extendibles;

class AppMenu extends \Hubleto\Framework\Extendible
{
  public function getItems(): array
  {
    return [
      [
        'app' => $this->app,
        'url' => 'workers',
        'title' => $this->app->translate('Workers'),
        'icon' => 'fas fa-user-tie',
      ],
    ];
  }
}
