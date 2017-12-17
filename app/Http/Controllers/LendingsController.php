<?php

namespace App\Http\Controllers;

use App\Lending;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LendingsController extends Controller
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

        $user = User::find(auth()->id());
        $friend_requests = $user->getFriendRequests();
        $friends = $user->getFriends();

        return view('lendings.create', compact('friend_requests', 'friends'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $lendings = [];

      $this->validate($request, [
        'amount'  => 'required',
        'recipient_id' => 'required',
      ]);

      foreach($request->recipient_id as $recipient_id) {
        $lendings[] = [
          'user_id'    => auth()->id(),
          'recipient_id' => $recipient_id,
          'amount'     => $request->amount,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ];
      }

      Lending::insert($lendings);

      return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lending  $lending
     * @return \Illuminate\Http\Response
     */
    public function show(Lending $lending)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lending  $lending
     * @return \Illuminate\Http\Response
     */
    public function edit(Lending $lending)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lending  $lending
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lending $lending)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lending  $lending
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lending $lending)
    {
        $lending->delete();

        return redirect()->back();
    }
}
