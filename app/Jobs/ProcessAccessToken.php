<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessAccessToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

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
      if($this->data['user']->access_token == null && $this->data['code'] != null) {

        $client = new \GuzzleHttp\Client();

        $code = $this->data['code'];

        try {
          $response = $client->request('POST', 'https://coins.ph/user/oauthtoken', [

            'headers' => [
              'content-type' => 'application/x-www-form-urlencoded'
            ],

            'form_params' => [
              'grant_type'    => 'authorization_code',
              'client_secret' => config('coins.secret_key'),
              'client_id'     => config('coins.client_id'),
              'code'          => $code,
              'redirect_uri'  => config('coins.redirect_uri'),
              '_token'        => csrf_token(),
            ]

          ]);

        } catch (\Exception $e) {

          abort(403);

        }

        $access_token = json_decode($response->getBody()->getContents())->access_token;

        $this->data['user']->access_token = $access_token;

        $this->data['user']->save();

        return $access_token;
      }

      return $this->data['user']->access_token;
    }
}
