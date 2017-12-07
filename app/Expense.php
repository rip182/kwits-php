<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

  public function leechers() {
    $this->hasMany('App\Leech', 'expense_id');
  }

  public function payment() {
    $this->morphOne('App\Payment', 'payable');
  }
}
