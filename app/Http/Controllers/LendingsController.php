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
        Lending::create([
          'user_id'    => auth()->id(),
          'recipient_id' => $recipient_id,
          'amount'     => $request->amount,
        ]);
        // $lendings[] = [
        //
        //   'created_at' => Carbon::now(),
        //   'updated_at' => Carbon::now(),
        // ];
      }

      $recipients = User::whereIn('id', $request->recipient_id)->get();



      // Lending::insert($lendings);

      return redirect()
        ->back()
        ->with('flash', "You just lent Php" . $request->amount . " to " . $this->formatNames($recipients) );

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
        $this->authorize('delete', $lending);

        $lending->delete();

        if(request()->expectsJson()) {
          return response(['status' => "Lend deleted"]);
        }

        return redirect()->back();
    }

    protected function formatNames($recipients)
    {
      $names = [];

      foreach($recipients as $recipient) {
        $names[] = $recipient->name;
      }

      if ( ! empty($names) ) {
        return join(', and ', array_filter(array_merge(array(join(', ', array_slice($names, 0, -1))), array_slice($names, -1)), 'strlen'));
      }

    }
}
