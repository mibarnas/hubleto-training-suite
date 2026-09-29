<?php

namespace Hubleto\App\External\TrainingSuite\Workers;

/**
 * Content of the first-run guide shown on this app's main page.
 *
 * Plain English strings translated by the controller that hands them to the
 * view, the same arrangement Questionnaires uses for its question catalogue.
 * The mechanics live in \Hubleto\App\External\TrainingSuite\Common\Onboarding.
 */
class Onboarding
{
  const KEY = 'workers';

  const STEPS = [
    [
      'icon' => 'fas fa-user-tie',
      'title' => 'One record per person',
      'body' => 'A worker is the person who attends trainings: their personal details, employer and address. Attendees, orders and certificates all point back to a worker, so somebody who takes three courses still has a single record here. E-mail addresses are unique, and they are what the bulk importer matches on.',
    ],
    [
      'icon' => 'fas fa-user-plus',
      'title' => 'Two ways a worker gets here',
      'body' => 'Add a single person with the Add Worker button. For company orders you usually do not add anyone by hand: attaching the filled-in .xlsx to a training order creates every worker that cannot be matched to an existing e-mail address.',
    ],
    [
      'icon' => 'fas fa-rotate',
      'title' => 'Retraining is calculated, not stored',
      'body' => 'The Next retraining date and Training to retake columns are read from the worker\'s certificates every time the list is shown: the certificate that expires soonest, or, once they have all lapsed, the one that expired most recently. There is nothing to keep up to date by hand.',
    ],
    [
      'icon' => 'fas fa-address-card',
      'title' => 'The whole history on one card',
      'body' => 'Opening a worker shows tabs for their trainings, schedules, certificates and orders, so you can answer what this person has done with us without leaving the page.',
    ],
    [
      'icon' => 'fas fa-bell',
      'title' => 'Reminders go out on their own',
      'body' => 'A nightly job e-mails a retraining reminder six months before a certificate expires, and again one month before if the worker has not signed up in the meantime. Workers who belong to a company are not mailed individually; their employer gets one digest at the start of the year. Every send is recorded, so re-running the job never mails twice.',
    ],
  ];
}
