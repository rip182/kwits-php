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
        $users  = User::where('id', '!=', Auth::id())->get();

        $user = User::find(Auth::id());

        $friends = collect($users)->map(function ($friend) use ($user) {

            $obligations        = $friend->obligations($user->id)->sum('amount');

            $user_contributions = $user->contributions($friend->id)->sum('amount');

            $friend_seeds       = $friend->seeds($user->id)->sum('amount');

            $user_debts         = $user->debts($friend->id)->sum('amount');

            return [

              'name'        => $friend->name,

              'owes'        => ($obligations + $user_contributions) - ($friend_seeds + $user_debts),

              'path'        => "/friends/" . $friend->id,

            ];

        });

        return view('home', compact('friends', 'user'));
    }
}
