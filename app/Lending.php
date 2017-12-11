<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id', 'recipient_id', 'amount',
  ];

  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function recipient()
  {
      return $this->belongsTo('App\User', 'recipient_id');
  }

}
