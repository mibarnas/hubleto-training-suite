<?php

namespace Hubleto\App\External\TrainingSuite\Common;

/**
 * First-run guide shown on the main page of each custom app.
 *
 * The guide opens by itself the first time a user lands on an app, and can be
 * reopened from the button next to the page title afterwards. Which guides a
 * user has already dismissed is kept in the `config` table under
 * `user/<idUser>/onboarding/<guide>`, so it follows the person between
 * browsers rather than living in one machine's local storage.
 *
 * The content of each guide belongs to its app (`Hubleto\App\External\TrainingSuite\<App>
 * \Onboarding::STEPS`); only the plumbing is here.
 */
class Onboarding extends \Hubleto\Erp\Core
{
  /**
   * Every guide there is, keyed by the slug the browser sends back. Nothing
   * outside this list can be marked as seen.
   */
  const GUIDES = [
    \Hubleto\App\External\TrainingSuite\Workers\Onboarding::KEY => \Hubleto\App\External\TrainingSuite\Workers\Onboarding::class,
    \Hubleto\App\External\TrainingSuite\Trainings\Onboarding::KEY => \Hubleto\App\External\TrainingSuite\Trainings\Onboarding::class,
    \Hubleto\App\External\TrainingSuite\TrainingOrders\Onboarding::KEY => \Hubleto\App\External\TrainingSuite\TrainingOrders\Onboarding::class,
    \Hubleto\App\External\TrainingSuite\Questionnaires\Onboarding::KEY => \Hubleto\App\External\TrainingSuite\Questionnaires\Onboarding::class,
  ];

  /** Under `user/<idUser>/` in the `config` table; at the root once filtered. */
  const CONFIG_PATH = 'onboarding/';

  public function exists(string $guide): bool
  {
    return isset(self::GUIDES[$guide]);
  }

  /** The untranslated steps of a guide. */
  public function getSteps(string $guide): array
  {
    if (!$this->exists($guide)) return [];
    return (array) constant(self::GUIDES[$guide] . '::STEPS');
  }

  public function hasBeenSeen(string $guide): bool
  {
    if ((int) $this->authProvider()->getUserId() <= 0) {
      return true; // never greet a page nobody is signed in to
    }

    // Read at the root, not under `user/<id>/`: Renderer::render() calls
    // ConfigManager::filterByUser(), which merges the signed-in user's subtree
    // into the root and drops `user` before any controller runs.
    return $this->config()->getAsBool(self::CONFIG_PATH . $guide);
  }

  public function markAsSeen(string $guide): void
  {
    if (!$this->exists($guide)) return;

    // ConfigManager::saveForUser() adds the `user/<idUser>/` prefix itself.
    $this->config()->saveForUser(self::CONFIG_PATH . $guide, '1');
  }

  /**
   * Makes the guide open again on the next visit. Not reachable from the UI
   * yet -- it is here so "show me that again for everyone" is a one-liner.
   */
  public function reset(string $guide): void
  {
    $idUser = (int) $this->authProvider()->getUserId();
    if ($idUser <= 0) return;

    $this->config()->delete('user/' . $idUser . '/' . self::CONFIG_PATH . $guide);
  }

  /**
   * Everything the view component needs. Steps are translated here, in the
   * caller's context, so each app keeps its own dictionary.
   */
  public function getViewParams(\Hubleto\Framework\Interfaces\CoreInterface $translateIn, string $guide): array
  {
    return [
      'guide' => $guide,
      'seen' => $this->hasBeenSeen($guide),
      'steps' => array_map(fn($step) => [
        'icon' => $step['icon'],
        'title' => $translateIn->translate($step['title']),
        'body' => $translateIn->translate($step['body']),
      ], $this->getSteps($guide)),
    ];
  }
}
