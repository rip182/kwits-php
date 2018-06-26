<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Traits\CreateSplit;

class CreateEqualSplit implements ShouldQueue
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
      $this->setOweAmount()
        ->createExpense()
        ->createPayment()
        ->createLeech();

      return redirect()
        ->back()
        ->with('flash', 'A new expense has been created.');
    }

    private function setOweAmount()
    {
      $split = count($this->data['user_id']) + 1;
      $owe_amount = $this->data['amount'] / $split;
      $this->owe_amount = $owe_amount;

      return $this;
    }

}
