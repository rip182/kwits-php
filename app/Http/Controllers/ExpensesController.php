<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $friends = User::where('id', '!=', Auth::id())->get();

        return view('expenses.create', compact('friends'));
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

        $expense = Expense::create([
          'name' => $request->name,
          'amount' => $request->amount
        ]);

        Payment::create([
          'user_id'       => Auth::id(),
          'payable_id'    => $expense->id,
          'payable_type'  => 'App\Expense',
          'amount'        => $request->amount,
        ]);

        $split = count($request->user_id) + 1;
        $owe_amount = $request->amount / $split;

        foreach($request->user_id as $user_id) {
          $leeches[] = [
            'user_id'    => $user_id,
            'leech_from' => Auth::id(),
            'expense_id' => $expense->id,
            'amount'     => $owe_amount,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
          ];
        }

        Leech::insert($leeches);

        return redirect('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
