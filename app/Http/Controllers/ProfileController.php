<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function myProfile()
    {
      $user = User::find(auth()->id());

      $expense_payments     = $user->expensePayments();

      $seeds                = $user->seeds();

      $obligations          = $user->obligations();

      $lendings              = $user->lendings()->get();

      $activities = collect();

      $activities = $activities->merge($expense_payments);

      $activities = $activities->merge($seeds);

      $activities = $activities->merge($obligations);

      $activities = $activities->merge($lendings);

      $activities_sorted = $activities->sortByDesc('created_at');

      $friend_requests = $user->getFriendRequests();

      return view('profiles.my-profile', compact('activities_sorted', 'user', 'friend_requests'));
    }
}
