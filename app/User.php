<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Hootlex\Friendships\Traits\Friendable;

use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;
use Overtrue\LaravelFollow\Traits\CanLike;

class User extends Authenticatable
{
    use Notifiable, Friendable, CanFollow, CanBeFollowed, CanLike;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'access_token',
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

    public function wallets() {
      return $this->hasMany('App\Wallet', 'user_id');
    }

    public function payments() {
      return $this->hasMany('App\Payment', 'user_id');
    }

    public function travels() {
      return $this->hasMany('App\Travel', 'user_id');
    }

    public function lendings($id = null) {
      if($id == null)
        return $this->hasMany('App\Lending', 'user_id');

      return $this->hasMany('App\Lending', 'user_id')->where('recipient_id', $id)->get();
    }

    public function travelObligations($id, $expense_ids)
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

      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->whereNull('travel_id')->get();
    }

    public function travelSeeds($id = null, $travel_id) {
      if($id == null)
        return $this->payments()->where('payable_type', 'App\User')->get();

      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->where('travel_id', $travel_id)->get();
    }

    public function seeds($id = null) {
      if($id == null)
        return $this->payments()->where('payable_type', 'App\User')->get();

      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->get();
    }

    public function otherContributions($id) {
      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->whereNull('travel_id')->get();
    }

    public function travelContributions($id, $travel_id) {
      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->where('travel_id', $travel_id)->get();
    }

    //User methods
    public function contributions($id) {
      return $this->payments()->where('payable_id', $id)->where('payable_type', 'App\User')->get();
    }

    public function travelDebts($id, $expense_ids)
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
