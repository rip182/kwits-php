<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetCryptoAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $access_token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->access_token) {
          $client = new \GuzzleHttp\Client();

          try {
            $response = $client->request('GET', 'https://coins.ph/api/v3/crypto-accounts?currency=PBTC', [
              'headers' => [
                'Authorization' => 'Bearer '.$this->access_token,
                'Content-Type'  => 'application/json;charset=UTF=8',
                'Accept'        => 'application/json'
              ]
            ]);

          } catch (\Exception $e) {

            abort(403);

          }

          return json_decode($response->getBody()->getContents(), true)['crypto-accounts'][0];
        }

        return null;
    }
}
