<?php

namespace App;

trait RecordsActivity
{
  protected static function bootRecordsActivity()
  {
    foreach(static::getActivitiesToRecord() as $event) {
      static::$event(function ($model) use ($event){
        $model->recordActivity($event);
      });
    }

  }

  protected static function getActivitiesToRecord()
  {
    return ['created', 'deleted'];
  }

  protected function recordActivity($event)
  {
    $this->activity()->create([
        'user_id' => auth()->id(),
        'type'    => $this->getActivityType($event),
    ]);
  }

  public function activity()
  {
    return $this->morphMany('App\Activity', 'subject');
  }

  protected function getActivityType($event)
  {
    return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
  }
}
