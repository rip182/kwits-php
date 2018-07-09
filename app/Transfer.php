<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'transfer_id', 'status', 'user_id', 'account', 'exchange', 'payment', 'target_address', 'amount',
  ];

  public function user() {
    return $this->belongsTo('App\User');
  }
}
