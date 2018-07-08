<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Leech;
use App\Lending;
use App\Wallet;
use App\Jobs\ProcessAccessToken;
use App\Jobs\GetCryptoAccount;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->request->get('user');

        $data = [
          'user' => $user,
          'code' => $this->request->code,
        ];

        $access_token = dispatch_now(new ProcessAccessToken($data));

        $crypto_account = dispatch_now(new GetCryptoAccount($access_token));

        if($crypto_account == 401) {
          //delete access_token
          $user->access_token = "";
          $user->save();
          return redirect()->back();
        }

        if($crypto_account) {
          $wallet = Wallet::firstOrNew(['coins_id' => $crypto_account['id']]);
          $wallet->address = $crypto_account['default_address'];
          $wallet->type    = $crypto_account['currency'];
          $wallet->user_id = $user->id;
          $wallet->save();
        }

        $users  = $user->getFriends();

        $total_owes = 0;

        $friends = collect($users)->map(function ($friend) use ($user, &$total_owes) {
            //@NOTE: codes below are reused in FriendsController
            $obligations        = $friend->obligations($user->id)->sum('amount');

            $user_contributions = $user->contributions($friend->id)->sum('amount');

            $friend_seeds       = $friend->seeds($user->id)->sum('amount');

            $user_debts         = $user->debts($friend->id)->sum('amount');

            $friend_lendings    = $friend->lendings($user->id)->sum('amount');

            $user_lendings      = $user->lendings($friend->id)->sum('amount');

            $owes               = ($user_lendings + $obligations + $user_contributions) - ($friend_seeds + $user_debts + $friend_lendings);

            $total_owes         += $owes;

            return [

              'id'              => $friend->id,

              'name'            => $friend->name,

              'owes'            => $owes,

              'path'            => "/friends/" . $friend->id,

              'joined'          => $friend->created_at->diffForHumans(),

              'has_wallet'      => ($friend->wallets()->get()->isEmpty() ? 0 : 1),
            ];

        });

        $friend_requests = $user->getFriendRequests();

        return view('dashboard.index', compact('friends', 'user', 'total_owes', 'friend_requests', 'crypto_account'));
    }
}
