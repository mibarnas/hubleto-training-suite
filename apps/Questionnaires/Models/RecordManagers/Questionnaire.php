<?php

namespace Hubleto\App\External\TrainingSuite\Questionnaires\Models\RecordManagers;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Questionnaire extends \Hubleto\Erp\RecordManager
{
  public $table = 'questionnaires';

  public function ATTENDEE(): BelongsTo
  {
    return $this->belongsTo(\Hubleto\App\External\TrainingSuite\Trainings\Models\RecordManagers\Attendee::class, 'id_attendee', 'id');
  }
}
