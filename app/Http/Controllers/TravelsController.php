<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Travel;
use App\Member;
use App\Payment;

class TravelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->request->get('user');

        $travels = $this->request->get('travels');

        $friend_requests = $user->getFriendRequests();

        return view('travels.index', compact('travels', 'friend_requests'));
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

      return view('travels.create', compact('friends', 'friend_requests'));
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

      $travel = Travel::create([
        'name' => $request->name,
        'user_id' => auth()->id(),
      ]);

      Member::insert([
        'user_id'       => auth()->id(),
        'travel_id'      => $travel->id,
        'created_at'    => Carbon::now(),
        'updated_at'    => Carbon::now(),
      ]);

      foreach($request->user_id as $user_id) {
        Member::create([
          'user_id'       => $user_id,
          'travel_id'      => $travel->id,
          'created_at'    => Carbon::now(),
          'updated_at'    => Carbon::now(),
        ]);
      }

      return redirect()
        ->back()
        ->with('flash', 'A new travel has been created.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $user = $this->request->get('user');

      $travel = $this->request->get('travel');

      $travel_buddies = $travel->user->name . ", ";

      $members = $this->request->get('members');

      foreach($members as $member) {

        $travel_buddies .= $member->user->name . ", ";

      }

      $expense_ids       = $travel->expenses()->pluck('expenses.id')->toArray();

      $total_expenses    = $travel->expenses()->sum('amount');

      $payments = Payment::whereIn('payable_id', $expense_ids)
        ->latest()
        ->with('payable')
        ->where('payable_type', 'App\Expense')
        ->orderBy('created_at', 'DESC')
        ->get()
        ->groupBy(function($payment){
          return $payment->created_at->format("Y-m-d");
        });

      $friend_requests = $user->getFriendRequests();

      return view('travels.show', compact('travel', 'friend_requests', 'members', 'payments', 'total_expenses', 'travel_buddies'));
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
