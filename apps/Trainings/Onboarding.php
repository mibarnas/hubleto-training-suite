<?php

namespace Hubleto\App\External\TrainingSuite\Trainings;

/**
 * Content of the first-run guide shown on this app's main page.
 * See \Hubleto\App\External\TrainingSuite\Common\Onboarding for the mechanics.
 */
class Onboarding
{
  const KEY = 'trainings';

  const STEPS = [
    [
      'icon' => 'fas fa-chalkboard-user',
      'title' => 'The course catalogue',
      'body' => 'A training is a course you offer, not a date: its name and number, the price per person, how many years its certificate stays valid, and the .docx template the certificates are printed from. The dates people actually attend are Schedules.',
    ],
    [
      'icon' => 'fas fa-file-word',
      'title' => 'Certificate templates',
      'body' => 'Upload a .docx that marks its variable parts with << placeholder >>. Every upload is scanned, and the form tells you straight away which values the template asks for, which of them cannot be supplied, and which required ones it forgot, so a template can be replaced without any code change.',
    ],
    [
      'icon' => 'fas fa-calendar-days',
      'title' => 'Schedules are the dates',
      'body' => 'A schedule is one run of a training: start and end, capacity, and the meeting link for online courses. The registered attendee count is counted at display time, so it can never drift from the people actually signed up.',
    ],
    [
      'icon' => 'fas fa-user-graduate',
      'title' => 'Attendees',
      'body' => 'An attendee links a worker to a schedule, and the same worker cannot be registered twice for the same date. This is also where you tick Passed, which is what unlocks certificate generation.',
    ],
    [
      'icon' => 'fas fa-paper-plane',
      'title' => 'Bulk e-mails from a schedule',
      'body' => 'Open a schedule to mail all of its attendees at once: the meeting link as one message, or the catalog sheet and satisfaction questionnaire, which goes out as a personal one-time link per attendee. Every send is written to log/emails.',
    ],
    [
      'icon' => 'fas fa-certificate',
      'title' => 'Certificates',
      'body' => 'Generate a certificate from the attendee once they have passed. You get the PDF and the source .docx, and the expiry date it carries is what drives the retraining reminders back in Workers.',
    ],
  ];
}
