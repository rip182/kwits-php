<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class FriendsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $friend)
    {
        $user = User::find(Auth::id());

        $obligations          = $friend->obligations($user->id)->sum('amount');

        $user_contributions   = $user->contributions($friend->id)->sum('amount');

        $friend_seeds         = $friend->seeds($user->id)->sum('amount');

        $user_debts           = $user->debts($friend->id)->sum('amount');

        $total                = $obligations + $user_contributions;

        $friend_contributions = $friend_seeds + $user_debts;

        $owes                 = $total - $friend_contributions;

        if($friend_contributions == 0)
          $percentage = 0;
        else if($friend_contributions > $total)
          $percentage = ($total / $friend_contributions) * 100;
        else
          $percentage = ($friend_contributions / $total) * 100;

        $summary = [
          'amount'            => $owes,
          'total_owes'        => $total,
          'contributions'     => $friend_contributions,
          'percentage'        => ceil($percentage),
        ];

        return view('friends.show', compact('friend', 'summary'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
