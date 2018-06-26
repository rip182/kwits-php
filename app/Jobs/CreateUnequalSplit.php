<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Traits\CreateSplit;
use App\Leech;


class CreateUnequalSplit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CreateSplit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $this->setOweAmount();

      if((int)$this->data['amount'] < $this->owe_amount) {
        return redirect()
          ->back()
          ->with('flash', 'The total of everyone\'s owed shares (' .$this->owe_amount.') is different than the total cost ('.$this->data['amount'].')');
      }

      $this->createExpense()
        ->createPayment()
        ->createLeech();

      return redirect()
        ->back()
        ->with('flash', 'A new expense has been created.');
    }

    private function setOweAmount()
    {
      foreach($this->data['user_id'] as $user_id => $owe_amount) {
        $this->owe_amount += (int)$owe_amount;
      }

      return $this;
    }

    private function createLeech()
    {
      foreach($this->data['user_id'] as $user_id => $owe_amount) {
        if($owe_amount != null) {
          Leech::create([
            'user_id'    => $user_id,
            'leech_from' => auth()->id(),
            'expense_id' => $this->expense->id,
            'amount'     => $owe_amount,
          ]);
        }
      }
    }
}
