<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Leech;
use App\Lending;
use App\Payment;

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

        $friend_ids  = $user->getFriends()->pluck('id')->all();

        $payments = Payment::whereIn('user_id', $friend_ids)
          ->where('payable_type', 'App\Expense')
          ->orderBy('created_at', 'DESC')
          ->get();

        $feeds = collect($payments)->map(function ($payment) {
          return [
            'expense' => $payment->payable,
            'paid_by'    => $payment->user,
            'split_count' => $payment->payable->leechers()->count() + 1,
            'comments' => [],
            'comments_count' => '',
            'feed_likes_count' => '',
          ];
        });

        $friend_requests = $user->getFriendRequests();

        return view('home', compact('feeds', 'user', 'friend_requests'));
    }
}
