<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Payment;
use App\Leech;

class ExpensesController extends Controller
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
        $friends = $user->getFriends();
        $friend_requests = $user->getFriendRequests();

        return view('expenses.create', compact('friends', 'friend_requests'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $leeches = [];

        $this->validate($request, [
          'amount'  => 'required',
          'user_id' => 'required',
          'group_id' => 'required',
        ]);

        $expense = Expense::create([
          'name' => $request->name,
          'group_id' => $request->group_id,
          'amount' => $request->amount
        ]);

        Payment::insert([
          'user_id'       => auth()->id(),
          'payable_id'    => $expense->id,
          'payable_type'  => 'App\Expense',
          'amount'        => $request->amount,
          'created_at'    => Carbon::now(),
          'updated_at'    => Carbon::now(),
        ]);

        $split = count($request->user_id) + 1;
        $owe_amount = $request->amount / $split;

        foreach($request->user_id as $user_id) {
          Leech::create([
            'user_id'    => $user_id,
            'leech_from' => auth()->id(),
            'expense_id' => $expense->id,
            'amount'     => $owe_amount,
          ]);
        }

        return redirect()
          ->back()
          ->with('flash', 'A new expense has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        $user = User::find(auth()->id());
        $friend_requests = $user->getFriendRequests();

        return view('expenses.show', compact('expense', 'friend_requests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
      $expense->update([
        'name'          => $request->name,
        'amount'       => $request->amount,
      ]);

      $expense->payment()->update([
        'amount'        => $request->amount
      ]);

      $leechers = Leech::where('expense_id', $expense->id);

      $split = $leechers->count() + 1;
      $owe_amount = $request->amount / $split;

      Leech::where('expense_id', $expense->id)->update([
        'amount' => $owe_amount
      ]);

      return response(['status' => 'Expense updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        if(request()->expectsJson()) {
          return response(['status' => "Expense deleted"]);
        }

        return redirect()->back();
    }
}
