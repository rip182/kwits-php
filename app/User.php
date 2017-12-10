<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Hootlex\Friendships\Traits\Friendable;

class User extends Authenticatable
{
    use Notifiable, Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function expensePayments($user) {
      $expense_ids = [];

      $leeches = $user->leeches()->where('leech_from', $this->id)->get();

      foreach($leeches as $leech) {
        $expense_ids[] = $leech->expense_id;
      }

      if(empty($expense_ids))
        return collect();

      return $this->payments()->where('payable_type', 'App\Expense')->whereIn('payable_id', $expense_ids)->get();

    }

    public function leeches() {
      return $this->hasMany('App\Leech', 'user_id');
    }

    public function payments() {
      return $this->hasMany('App\Payment', 'user_id');
    }

    //Friend methods
    public function obligations($id) {
      return $this->leeches()->where('leech_from', $id)->get();
    }

    public function seeds($id) {
      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->get();
    }

    //User methods
    public function contributions($id) {
      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->get();
    }

    public function debts($id) {
      return $this->leeches()->where('leech_from', $id)->get();
    }

}
