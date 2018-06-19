<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Group;
use App\Member;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->request->get('user');

        $groups = $this->request->get('groups');

        $friend_requests = $user->getFriendRequests();

        return view('groups.index', compact('groups', 'friend_requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $user = $this->request->get('user');

      $friends = $user->getFriends();

      $friend_requests = $user->getFriendRequests();

      return view('groups.create', compact('friends', 'friend_requests'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'name'  => 'required',
        'user_id' => 'required',
      ]);

      $group = Group::create([
        'name' => $request->name,
        'user_id' => auth()->id(),
      ]);

      Member::insert([
        'user_id'       => auth()->id(),
        'group_id'      => $group->id,
        'created_at'    => Carbon::now(),
        'updated_at'    => Carbon::now(),
      ]);

      foreach($request->user_id as $user_id) {
        Member::create([
          'user_id'       => $user_id,
          'group_id'      => $group->id,
          'created_at'    => Carbon::now(),
          'updated_at'    => Carbon::now(),
        ]);
      }

      return redirect('home')
        ->with('flash', 'A new group has been created.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
