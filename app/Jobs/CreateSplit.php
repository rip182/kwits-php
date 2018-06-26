<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Traits\Split;
use App\Jobs\EqualSplit;
use App\Jobs\UnequalSplit;

class CreateSplit implements ShouldQueue
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
        if($this->data['split'] == "equal") {
          return dispatch_now(new EqualSplit($this->data));
        }

        if($this->data['split'] == "unequal") {
          return dispatch_now(new UnequalSplit($this->data));
        }
    }
}
