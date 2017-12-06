<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
class UserController extends Controller
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
        $summary = $this->getDashboardSummary($id);

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

    private function getDashboardSummary($id)
    {
      $user = User::find($id);

      $summary = [
        "user" => [
          "name" => $user->name,
          "status" => 0,
          "total" => 0,
          "message" => ""
        ],
        "friends" => []
      ];

      $friends              = $this->getFriends($id);

      $owed_friends         = $this->getOwedFriends($id);

      $my_settlements       = $this->getMySettlements($id);

      $friends_settlements  = $this->getFriendsSettlements($id);

      $my_owes              = $this->getMyOwes($id);

      foreach($friends as $friend) {
        $summary["friends"][] = [
          'user_id' => $friend->id,
          'name'    => $friend->name,
          'status'  => 0,
          'amount'  => 0,
          'message' => "",
        ];
      }

      $this->processSumOfAmountOwedFromFriends($summary, $owed_friends);

      $this->processSumOfAmountFriendsPaid($summary, $my_settlements);

      $this->processSumOfAmountPaidToFriends($summary, $friends_settlements);

      $this->processSumOfAmountOwedToFriends($summary, $my_owes);

      $this->updateSummary($summary);

      return $summary;

    }

    private function updateSummary(&$summary)
    {
      foreach($summary["friends"] as $key => $row) {
        //you owe friend the amount
        if($row['amount'] <= 0) {
          $summary["friends"][$key]['message'] = "You owe " .$row['name'] . " Php" . abs($row['amount']);
          $summary["friends"][$key]['amount'] = abs($row['amount']);
        } else {
          $summary["friends"][$key]['status'] = 1;
          $summary["friends"][$key]['message'] = $row['name'] . " owes you Php" . $row['amount'];
        }
      }

      foreach($summary["friends"] as $key => $row) {
        if($row['status'] == 0) {
          $summary['user']['total'] -= $row['amount'];
        } else {
          $summary['user']['total'] += $row['amount'];
        }
      }

      if($summary['user']['total'] <= 0) {
        $summary['user']['message'] = "You owe Php" . abs($summary['user']['total']);
        $summary['user']['total'] = abs($summary['user']['total']);
      } else {
        $summary['user']['status'] = 1;
        $summary['user']['message'] = "Friends owe you Php" . $summary['user']['total'];
      }
    }

    private function processSumOfAmountOwedToFriends(&$summary, $my_owes)
    {
      foreach($summary["friends"] as $key => $row) {
        foreach($my_owes as $my_owe) {
          if($my_owe->user_id == $row['user_id']) {
            $summary["friends"][$key]['amount'] -= $my_owe->amount;
          }
        }
      }
    }

    private function processSumOfAmountFriendsPaid(&$summary, $my_settlements)
    {
      foreach($summary["friends"] as $key => $row) {
        foreach($my_settlements as $my_settlement) {
          if($my_settlement->user_id == $row['user_id']) {
            $summary["friends"][$key]['amount'] += $my_settlement->amount;
          }
        }
      }
    }

    private function processSumOfAmountPaidToFriends(&$summary, $friends_settlements)
    {
      foreach($summary["friends"] as $key => $row) {
        foreach($friends_settlements as $friends_settlement) {
          if($friends_settlement->user_id == $row['user_id']) {
            $summary["friends"][$key]['amount'] -= $friends_settlement->amount;
          }
        }
      }
    }

    private function processSumOfAmountOwedFromFriends(&$summary, $owed_friends)
    {
      foreach($summary["friends"] as $key => $row) {
        foreach($owed_friends as $owed_friend) {
          if($owed_friend->user_id == $row['user_id']) {
            $summary["friends"][$key]['amount'] += $owed_friend->amount;
          }
        }
      }
    }

    private function getFriends($id)
    {
      return User::where('id', '!=', $id)->get();
    }

    private function getMyOwes($id)
    {
      return DB::table('users')->select('owes.owed_id as user_id', 'owes.amount')
        ->join('owes', 'owes.owed_id', 'users.id')
        ->where('owes.user_id', $id)->get();
    }

    private function getFriendsSettlements($id)
    {
      return DB::table('payments')->select('payments.user_id', 'amount')
        ->join('users', 'payments.user_id', '=', 'users.id')
        ->where('payable_type', '=', "User")
        ->where('payable_id', $id)->get();
    }

    private function getOwedFriends($id)
    {
      return DB::table('owes')->select('user_id', 'amount')->where('owed_id', $id)->get();
    }

    private function getMySettlements($id)
    {
      return DB::table('users')->select('payments.payable_id as user_id', 'amount')
        ->join('payments', 'payments.payable_id', '=', 'users.id')
        ->where('payments.user_id', $id)
        ->where('payable_type', "User")->get();
    }
}
