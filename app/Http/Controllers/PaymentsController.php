<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Jobs\PayWithCoins;
use App\Payment;
use App\User;
use App\Leech;
use App\Transfer;

class PaymentsController extends Controller
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
        $user = User::find(Auth::id());

        if($request->has('coins') && $request->coins == 1) {

          $this->validate($request, [
            'amount'          => 'required',
            'target_address'  => 'required',
          ]);

          $wallet = $user->wallets()->first();

          if($wallet) {
            $data = [
              'account'         => $wallet->coins_id,
              'target_address'  => $request->target_address,
              'amount'          => $request->amount,
              '_token'          => csrf_token(),
            ];

            $result = dispatch_now(new PayWithCoins($data, $user->access_token));

            $response = [
              'status' => $result['transfer']['status'],
              'account' => $result['transfer']['account'],
              'exchange' => $result['transfer']['exchange'],
              'payment' => $result['transfer']['payment'],
              'target_address' => $result['transfer']['target_address'],
              'amount' => $result['transfer']['amount'],
              'transfer_id' => $result['transfer']['id'],
              'user_id' => $user->id,
            ];

            Transfer::create($response);
          }
        }

        Payment::create([
          'user_id'       => Auth::id(),
          'payable_id'    => $request->user_id,
          'payable_type'  => 'App\User',
          'amount'        => $request->amount,
        ]);

        return redirect()
          ->back()
          ->with('flash', 'You have successfully paid P ' . $request->amount . ' to ' . $request->recipient_name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
      $payment->update([
        'payable_id' => $request->payable_id,
        'amount'       => $request->amount,
      ]);

      return response(['status' => 'Payment updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->back();
    }
}
