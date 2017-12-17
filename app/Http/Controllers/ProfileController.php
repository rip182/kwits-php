<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function myProfile()
    {
      $user = User::find(auth()->id());

      $activities =  $user->activities()->with('subject')->orderBy('created_at', 'Desc')->get();
      
      $friend_requests = $user->getFriendRequests();

      return view('profiles.my-profile', compact('activities', 'user', 'friend_requests'));
    }
}
