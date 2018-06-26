<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Traits\Split;

class UnequalSplit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Split;

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
        ->prepareLeechers()
        ->createLeechers();

      return redirect()
        ->back()
        ->with('flash', 'A new expense has been created.');
    }

    private function setOweAmount()
    {
      $owe_amount = 0;

      foreach($this->data['user_id'] as $user_id => $amount) {

        $owe_amount += (int)$amount;

      }

      $this->owe_amount = $owe_amount;

      return $this;
    }

    protected function prepareLeechers()
    {
      $leechers = [];

      foreach($this->data['user_id'] as $key => $value) {
        if($value != null) {
          $leechers[] = [
            'user_id' => $key,
            'amount'  => $value
          ];
        }
      }

      $this->leechers = $leechers;

      return $this;
    }
}
