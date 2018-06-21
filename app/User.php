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

    public function expensePayment($expense_id)
    {
      return $this->payments()->where('payable_type', 'App\Expense')->where('payable_id', $expense_id)->first();
    }

    public function expensePayments($user = null) {
      if($user == null) {
        return $this->payments()->where('payable_type', 'App\Expense')->get();
      } else {
        $expense_ids = [];

        $leeches = $user->leeches()->where('leech_from', $this->id)->get();

        foreach($leeches as $leech) {
          $expense_ids[] = $leech->expense_id;
        }

        if(empty($expense_ids))
          return collect();


        return $this->payments()->where('payable_type', 'App\Expense')->whereIn('payable_id', $expense_ids)->get();
      }
    }

    public function leeches() {
      return $this->hasMany('App\Leech', 'user_id');
    }

    public function payments() {
      return $this->hasMany('App\Payment', 'user_id');
    }

    public function groups() {
      return $this->hasMany('App\Group', 'user_id');
    }

    public function lendings($id = null) {
      if($id == null)
        return $this->hasMany('App\Lending', 'user_id');

      return $this->hasMany('App\Lending', 'user_id')->where('recipient_id', $id)->get();
    }

    public function groupObligations($id, $expense_ids)
    {
      return $this->leeches()->where('leech_from', $id)->whereIn('expense_id', $expense_ids)->get();
    }

    //Friend methods
    public function obligations($id = null) {
      if($id == null)
        return $this->leeches()->get();
      return $this->leeches()->where('leech_from', $id)->get();
    }

    public function otherSeeds($id = null) {
      if($id == null)
        return $this->payments()->where('payable_type', 'App\User')->get();

      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->whereNull('group_id')->get();
    }

    public function groupSeeds($id = null, $group_id) {
      if($id == null)
        return $this->payments()->where('payable_type', 'App\User')->get();

      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->where('group_id', $group_id)->get();
    }

    public function seeds($id = null) {
      if($id == null)
        return $this->payments()->where('payable_type', 'App\User')->get();

      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->get();
    }

    public function otherContributions($id) {
      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->whereNull('group_id')->get();
    }

    public function groupContributions($id, $group_id) {
      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->where('group_id', $group_id)->get();
    }

    //User methods
    public function contributions($id) {
      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->get();
    }

    public function groupDebts($id, $expense_ids)
    {
      return $this->leeches()->where('leech_from', $id)->whereIn('expense_id', $expense_ids)->get();
    }

    public function debts($id) {
      return $this->leeches()->where('leech_from', $id)->get();
    }

    public function activities()
    {
      return $this->hasMany('App\Activity');
    }

}
