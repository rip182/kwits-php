<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Activity;

class ProfileController extends Controller
{
    public function myProfile()
    {
      $user = auth()->user();

      return view('profiles.my-profile', [
        'user' => $user,
        'activities' => Activity::feed($user),
        'friend_requests' => $user->getFriendRequests(),
      ]);
    }
}
