<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Leech;
use App\Lending;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());

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

            ];

        });

        $friend_requests = $user->getFriendRequests();

        return view('home', compact('friends', 'user', 'total_owes', 'friend_requests'));
    }
}
