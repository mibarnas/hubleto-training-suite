<?php

namespace Hubleto\App\External\TrainingSuite\TrainingOrders;

/**
 * Content of the first-run guide shown on this app's main page.
 * See \Hubleto\App\External\TrainingSuite\Common\Onboarding for the mechanics.
 */
class Onboarding
{
  const KEY = 'training-orders';

  const STEPS = [
    [
      'icon' => 'fas fa-file-invoice',
      'title' => 'Who ordered what',
      'body' => 'An order records one booking for one training date, placed either by a private individual or by a company. The order number is assigned for you when the order is created.',
    ],
    [
      'icon' => 'fas fa-users',
      'title' => 'The form follows the order type',
      'body' => 'A private order asks for the one worker who is attending. A company order asks for the customer and the contact person instead, and can carry as many workers as the company sends.',
    ],
    [
      'icon' => 'fas fa-file-import',
      'title' => 'Importing a company\'s workers',
      'body' => 'Download the import template, have the company fill it in, attach it to the saved order, then use Preview import to see exactly what would happen before committing with Import workers. Meno, Priezvisko and E-mail are required; anyone whose e-mail is not on file yet is created as a new worker.',
    ],
    [
      'icon' => 'fas fa-list-check',
      'title' => 'The worker list is the attendee list',
      'body' => 'Workers on this order are simply the attendees created against it, so putting somebody on the order and registering them for the training date are one and the same action. There is no second list that can fall out of step.',
    ],
    [
      'icon' => 'fas fa-coins',
      'title' => 'Prices are read, not stored',
      'body' => 'Price per person comes from the booked schedule\'s training and the head count from the order\'s workers, so the total is recalculated every time it is shown and cannot go stale when a price changes.',
    ],
  ];
}
