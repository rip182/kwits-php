<?php

return [
  'client_id'     => env('COINS_CLIENT_ID'),
  'secret_key'    => env('COINS_SECRET_KEY'),
  'redirect_uri'  => env('COINS_REDIRECT_URI'),
  'auth'          => env('COINS_AUTH') . "client_id=".env('COINS_CLIENT_ID')."&token_type=Bearer&response_type=code"
];
