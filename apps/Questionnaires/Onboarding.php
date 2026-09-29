<?php

namespace Hubleto\App\External\TrainingSuite\Questionnaires;

/**
 * Content of the first-run guide shown on this app's main page.
 * See \Hubleto\App\External\TrainingSuite\Common\Onboarding for the mechanics.
 */
class Onboarding
{
  const KEY = 'questionnaires';

  const STEPS = [
    [
      'icon' => 'fas fa-clipboard-question',
      'title' => 'Answers, not a form to fill in',
      'body' => 'Every record here was submitted by an attendee through their own one-time public link. That is why questionnaires cannot be created by hand: this app is for reading the results.',
    ],
    [
      'icon' => 'fas fa-paper-plane',
      'title' => 'How they get here',
      'body' => 'Open a training date and use Send catalog sheet and questionnaire. Each attendee is mailed a personal link on which they confirm their own details, complete the catalog sheet and answer the questionnaire in a single pass. The link stops working once it has been used.',
    ],
    [
      'icon' => 'fas fa-star',
      'title' => 'What is recorded',
      'body' => 'Eleven ratings from 1 to 5 and three open answers. The ratings are stored as real columns so per-question averages and the CSV export stay fast, and the exact submitted payload is kept as JSON beside them for audit.',
    ],
    [
      'icon' => 'fas fa-clock',
      'title' => 'Filled on',
      'body' => 'The moment the attendee pressed submit. It is read-only everywhere, because it is evidence of when the feedback was given rather than something the office sets.',
    ],
  ];
}
