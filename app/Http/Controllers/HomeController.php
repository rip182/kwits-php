<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Leech;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());

        $users  = $user->getAcceptedFriendships();

        $total_owes = 0;

        $friends = collect($users)->map(function ($friend) use ($user, &$total_owes) {
            //@NOTE: codes below are reused in FriendsController
            $obligations        = $friend->recipient->obligations($user->id)->sum('amount');

            $user_contributions = $user->contributions($friend->recipient_id)->sum('amount');

            $friend_seeds       = $friend->recipient->seeds($user->id)->sum('amount');

            $user_debts         = $user->debts($friend->recipient_id)->sum('amount');

            $owes               = ($obligations + $user_contributions) - ($friend_seeds + $user_debts);

            $total_owes         += $owes;

            return [

              'id'              => $friend->recipient_id,

              'name'            => $friend->recipient->name,

              'owes'            => $owes,

              'path'            => "/friends/" . $friend->recipient_id,

            ];

        });

        $friend_requests = $user->getFriendRequests();

        return view('home', compact('friends', 'user', 'total_owes', 'friend_requests'));
    }
}
