<?php

namespace App\Http\Controllers;

use App\Events\PaymentWasPaid;
use App\Http\Requests;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lollypop\Gateways\GatewayMethodInterface;

class PaymentsController extends Controller
{

    /**
     * @var PaymentGatewayMethodInterface
     */
    private $paymentmethod;

    public function __construct(GatewayMethodInterface $paymentmethod)
    {
        $this->paymentmethod = $paymentmethod;
    }

    public function makePayment($paymentcode, Request $request)
    {

        $payment = Payment::where('code', $paymentcode)->firstOrFail();

        try{
            $this->paymentmethod->pay($payment->amount, $request);
        }catch (\Exception $e){
            \Bugsnag::notifyError("PaymentMethodError", $e->getMessage());
            return redirect()->back()->with("errorMsg",trans('ocp.paymentError'));
        }

        $this->updatePaymentStatus($payment);
        event(new PaymentWasPaid($payment));

        return redirect(route('thankyou'));

    }

    public function myAcount()
    {
        $user = Auth::user();
        $paymentLinks = Payment::where('user_id', $user->id)->orderBy('id','desc')->paginate(15);

        return view('myaccount')
          ->with('user', Auth::user())
          ->with('pendingLinks', $user->hasPendings() ? true : false)
          ->with('paymentLinks', $paymentLinks);

    }

    private function updatePaymentStatus($payment)
    {
        $payment->active = 0;
        $payment->paid = 1;
        $payment->gatewayref_id = $this->paymentmethod->response->transaction->_attributes['id'];
        $payment->paid_at = Carbon::now();
        $payment->save();
    }


}
