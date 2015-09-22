<?php

namespace App\Http\Middleware;

use App\Exceptions\PaymentException;
use App\Payment;
use Carbon\Carbon;
use Closure;
use Input;

class BeforeValidPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $payment = Payment::where('code', $request->segment(2))->first();

        // check if this code exists
        if (is_null($payment)) {
            throw new PaymentException(trans('exceptions.payment_invalid'));
        }

        // check if it is active
        if (!$payment->active) {
            throw new PaymentException(trans('exceptions.payment_is_not_active'));
        }

        // check if its expired
        if ($payment->updated_at->addHours(getenv('PAYMENT_HOURS_EXPIRATION')) < Carbon::now()) {
            $payment->active = 0;
            $payment->save();
            throw new PaymentException(trans('exceptions.payment_expired'));
        }

        Input::merge(['payment' => $payment]);

        return $next($request);
    }
}
