<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

  use RecordsActivity;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'amount',
  ];

  public function leechers() {
    return $this->hasMany('App\Leech', 'expense_id');
  }

  public function payment() {
    return $this->morphOne('App\Payment', 'payable');
  }

  protected static function boot()
  {
    parent::boot();
  }

}
