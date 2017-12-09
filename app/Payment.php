<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id', 'payable_id', 'payable_type', 'amount',
  ];

  /**
   * Get all of the owning payable models.
   */
  public function payable()
  {
      return $this->morphTo();
  }

  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function leechers()
  {
      return $this->hasMany('App\Leech', 'expense_id');
  }
}
