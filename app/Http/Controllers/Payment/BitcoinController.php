<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaymentTrait;
use Illuminate\Http\Request;
use Modules\Plan\Entities\Plan;
class BitcoinController extends Controller
{

    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request,$id)
    {
        $plan = Plan::find($id);
        session(['plan_id'=>$id]);
        return redirect()->away($plan->payment_link);
        // session()->flash('error', 'Something went wrong.');

        // return back();
    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
       return 'success';
    }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        //
    }
}
