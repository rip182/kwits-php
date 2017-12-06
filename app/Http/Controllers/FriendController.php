<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
class FriendController extends Controller
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
        $user = User::find(2);

        $friend = User::find($id);

        $friend_owes = $this->getFriendOwes($id, $user);

        $payments = $this->getUserPayments($id, $user);

        $friend_payments = $this->getFriendPayments($id, $user);

        $owes = $this->getUserOwes($id, $user);

        $total = $friend_owes->amount + $payments->amount;

        $friend_contributions = $friend_payments->amount + $owes->amount;

        $amount = $total - $friend_contributions;

        if($friend_contributions == 0)
          $percentage = 0;
        else if($friend_contributions > $total)
          $percentage = ($total / $friend_contributions) * 100;
        else
          $percentage = ($friend_contributions / $total) * 100;

        $summary = [
          'user_id'           => $friend->id,
          'name'              => $friend->name,
          'status'            => 0,
          'amount'            => $amount,
          'message'           => "",
          'total_owes'        => $total,
          'contributions'     => $friend_contributions,
          'percentage'        => $percentage,
        ];

        $this->updateSummary($summary);

        return $summary;
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

    private function getFriendOwes($id, $user)
    {
      return DB::table('owes')->select(DB::raw('SUM(amount) as amount'))
        ->where('owes.user_id', $id)
        ->where('owes.owed_id', $user->id)->first();
    }

    private function getUserPayments($id, $user)
    {
      return DB::table('payments')->select(DB::raw('SUM(amount) as amount'))
        ->where('payments.user_id', $user->id)
        ->where('payments.payable_type', 'User')
        ->where('payments.payable_id', $id)->first();
    }

    private function getFriendPayments($id, $user)
    {
      return DB::table('payments')->select(DB::raw('SUM(amount) as amount'))
        ->where('payments.user_id', $id)
        ->where('payments.payable_type', 'User')
        ->where('payments.payable_id', $user->id)->first();
    }

    private function getUserOwes($id, $user)
    {
      return DB::table('owes')->select(DB::raw('SUM(amount) as amount'))
        ->where('owes.user_id', $user->id)
        ->where('owes.owed_id', $id)->first();
    }

    private function updateSummary(&$summary)
    {
      if($summary['contributions'] >= $summary['total_owes']) {
        $summary['message'] = "You owe " . $summary['name'] . " Php" . abs($summary['amount']);

      } else {
        $summary['status'] = 1;
        $summary['message'] = $summary['name'] . " owes you Php" . $summary['amount'];
      }
    }
}
