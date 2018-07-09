<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PayWithCoins implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $access_token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $access_token)
    {
        $this->data = $data;
        $this->access_token = $access_token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $client = new \GuzzleHttp\Client();

      try {
        $response = $client->request('POST', 'https://coins.ph/api/v3/transfers/', [
          'headers' => [
            'Authorization' => 'Bearer '.$this->access_token,
            'Content-Type'  => 'application/json;charset=UTF=8',
            'Accept'        => 'application/json'
          ],

          'json' => $this->data,
        ]);

      } catch (\Exception $e) {

        return [
          'status' => false,
          'errors' => json_decode($e->getResponse()->getBody()->getContents(), true)['errors'],
        ];
      }

      return [
        'status'  => true,
        'message' => json_decode($response->getBody()->getContents(), true),
      ];
    }
}
