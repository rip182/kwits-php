<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owe extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'owes';

  public function expense()
  {
      return $this->belongsTo('App\Expense');
  }

  public function user()
  {
      return $this->belongsTo('App\User');
  }
}
