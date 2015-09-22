<?php

namespace App\Http\Controllers;

use App\Events\PaymentWasPaid;
use App\Http\Requests;
use App\Payment;
use App\User;
use Braintree_Customer;
use Braintree_Transaction;
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
        $nonce = $request->get('payment_method_nonce');

        $this->paymentmethod->pay($payment->amount,$request);

        $this->updatePaymentStatus($payment);
        event(new PaymentWasPaid($payment));
        return redirect(route('thankyou'));

    }

    public function myAcount()
    {
        $user = User::with('unpaidPayment')->where('id', Auth::user()->id)->firstOrFail();
        $unpaid = $user->unpaidPayment->first();

        if (!is_null($unpaid)) {
            return redirect('/payment/' . $unpaid->code);
        }else {
            return view('myaccount')->with('user', $user);
        }

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
