<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class ActivitiesController extends Controller
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
        $user = User::find(auth()->id());

        $expense_payments     = $friend->expensePayments($user);

        $seeds                = $friend->seeds($user->id);

        $obligations          = $friend->obligations($user->id);

        $friend_lendings      = $friend->lendings($user->id);

        $activities = collect();

        $activities = $activities->merge($expense_payments);

        $activities = $activities->merge($seeds);

        $activities = $activities->merge($obligations);

        $activities = $activities->merge($friend_lendings);

        $activities_sorted = $activities->sortByDesc('created_at');

        $friend_requests = $user->getFriendRequests();

        return view('activities.show', compact('activities_sorted', 'friend', 'friend_requests'));
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
