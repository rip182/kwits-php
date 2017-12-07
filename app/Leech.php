<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leech extends Model
{
    public function user() {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function expense() {
      return $this->belongsTo('App\Expense', 'expense_id');
    }
}
