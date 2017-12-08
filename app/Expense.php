<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'amount',
  ];

  public function leechers() {
    $this->hasMany('App\Leech', 'expense_id');
  }

  public function payment() {
    $this->morphOne('App\Payment', 'payable');
  }
}
