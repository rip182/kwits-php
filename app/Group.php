<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  use RecordsActivity;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id', 'name',
  ];

  public function user() {
    return $this->belongsTo('App\User');
  }

  public function groups() {
    return $this->hasMany('App\Member');
  }
}
