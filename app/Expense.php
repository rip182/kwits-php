<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'expenses';

  public function owes()
  {
    return $this->hasMany('App\Owe');
  }

  /**
 * Get all of the expense's payments.
 */
  public function payments()
  {
      return $this->morphMany('App\Payment', 'payable');
  }
}
