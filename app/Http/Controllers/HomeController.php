<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
        $user = $this->request->get('user');

        $friend_ids  = Cache::remember('friend_ids', 10, function() use ($user) {
          return $user->getFriends()->pluck('id')->all();
        });

        $friend_ids[] = $user->id;

        $payments = Cache::remember('payments', 10, function() use($friend_ids){
          return Payment::whereIn('user_id', $friend_ids)
            ->where('payable_type', 'App\Expense')
            ->orderBy('created_at', 'DESC')
            ->get();
        });

        $feed = Cache::remember('feed', 10, function() use ($payments) {
          return collect($payments)->map(function ($payment) {
            return [
              'expense' => $payment->payable,
              'paid_by'    => $payment->user,
              'split_count' => $payment->payable->leechers()->count() + 1,
              'comments' => [],
              'comments_count' => '',
              'feed_likes_count' => '',
            ];
          });
        });

        $friend_requests = Cache::remember('friend_requests', 10, function() use ($user) {
          $user->getFriendRequests();
        });

        return view('home', compact('feed', 'user', 'friend_requests'));
    }
}
