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
      'name', 'amount', 'group_id',
  ];

  public function leechers() {
    return $this->hasMany('App\Leech', 'expense_id');
  }

  public function payment() {
    return $this->morphOne('App\Payment', 'payable');
  }

  public function group() {
    return $this->belongsTo('App\Group');
  }

  protected static function boot()
  {
    parent::boot();

    static::deleting(function($expense){
      $expense->leechers->each->delete();
      $expense->payment->delete();
    });
  }

}
