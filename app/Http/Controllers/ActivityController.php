<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class ActivityController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $user = User::find(3);

      $friend = User::find($id);

      $friend_expense_payments = $this->getFriendExpensePayments($id, $user);

      $friend_payments = $this->getFriendPayments($id, $user);

      $friend_owes = $this->getFriendOwes($id, $user);

      $activities = collect(array_merge($friend_expense_payments, $friend_payments, $friend_owes));

      $activities_sorted = $activities->sortByDesc('created_at');

      return $activities_sorted;
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

    private function getFriendExpensePayments($id, $user)
    {
      $expense_payments = [];
      $db_result = DB::table('expenses')->select('expenses.name', 'payments.amount', 'expenses.created_at')
        ->join('payments', 'payments.payable_id', '=', 'expenses.id')
        ->join('owes', 'owes.expense_id', '=', 'expenses.id')
        ->where('payments.payable_type', 'Expense')
        ->where('payments.user_id', $id)
        ->where('owes.user_id', $user->id)->get();

      foreach($db_result as $row) {
        $expense_payments[] = [
          'type' => 'expense_payments',
          'name' => $row->name,
          'amount' => $row->amount,
          'created_at' => $row->created_at,
        ];
      }

      return $expense_payments;
    }

    private function getFriendPayments($id, $user)
    {
      $friend_payments = [];
      $db_result = DB::table('payments')->select('payments.amount', 'payments.created_at')
        ->where('payments.payable_type', 'User')
        ->where('payments.payable_id', $user->id)
        ->where('payments.user_id', $id)->get();

      foreach($db_result as $row) {
        $friend_payments[] = [
          'type' => 'payments',
          'name' => "",
          'amount' => $row->amount,
          'created_at' => $row->created_at,
        ];
      }

      return $friend_payments;
    }

    private function getFriendOwes($id, $user)
    {
      $friend_owes = [];
      $db_result = DB::table('owes')->select('expenses.name', 'owes.amount', 'expenses.created_at')
        ->join('expenses', 'expenses.id', '=', 'owes.expense_id')
        ->where('owes.user_id', $id)
        ->where('owes.owed_id', $user->id)->get();

      foreach($db_result as $row) {
        $friend_owes[] = [
          'type' => 'owes',
          'name' => $row->name,
          'amount' => $row->amount,
          'created_at' => $row->created_at,
        ];
      }

      return $friend_owes;
    }
}
