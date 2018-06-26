<?php

namespace App\Traits;

use App\Expense;
use App\Payment;
use App\Leech;

use Carbon\Carbon;

trait CreateSplit {

  protected $data;
  protected $owe_amount;
  protected $expense;

  private function createLeech()
  {
    foreach($this->data['user_id'] as $user_id) {
      Leech::create([
        'user_id'    => $user_id,
        'leech_from' => auth()->id(),
        'expense_id' => $this->expense->id,
        'amount'     => $this->owe_amount,
      ]);
    }
  }

  private function createPayment()
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

  private function createExpense()
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
