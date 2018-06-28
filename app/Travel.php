<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
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

  public function members() {
    return $this->hasMany('App\Member');
  }

  public function expenses() {
    return $this->hasMany('App\Expense');
  }
}
