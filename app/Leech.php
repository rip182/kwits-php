<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leech extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'leech_from', 'expense_id', 'amount',
    ];

    public function user() {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function expense() {
      return $this->belongsTo('App\Expense', 'expense_id');
    }
}
