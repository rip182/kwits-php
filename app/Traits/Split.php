<?php

namespace App\Traits;

use App\Expense;
use App\Payment;
use App\Leech;

use Carbon\Carbon;

trait Split {

  protected $data;
  protected $owe_amount;
  protected $expense;
  protected $leechers;

  protected function createLeechers()
  {
      foreach($this->leechers as $leecher) {
        Leech::create([
          'user_id'    => $leecher['user_id'],
          'leech_from' => auth()->id(),
          'expense_id' => $this->expense->id,
          'amount'     => $leecher['amount'],
        ]);
      }
  }

  protected function createPayment()
  {
    Payment::insert([
      'user_id'       => auth()->id(),
      'payable_id'    => $this->expense->id,
      'payable_type'  => 'App\Expense',
      'amount'        => $this->data['amount'],
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now(),
    ]);

    return $this;
  }

  protected function createExpense()
  {
    $expense = Expense::create([
      'name' => $this->data['name'],
      'group_id' => $this->data['group_id'],
      'amount' => $this->data['amount']
    ]);

    $this->expense = $expense;

    return $this;
  }

}
