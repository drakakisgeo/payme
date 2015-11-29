<?php

namespace App\Listeners;

use App\Events\PaymentWasPaid;
use Bugsnag;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use Monolog\Logger;
use Slack;

class PaymentCompletedActions
{

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  PaymentWasPaid  $event
     * @return void
     */
    public function handle(PaymentWasPaid $event)
    {
        $payment = $event->payment;
        $user = $event->payment->user;

        // Send Email
        $this->mailer->send('emails.paid', ['user' => $user,'payment'=>$payment], function ($m) use ($user) {
                $m->to($user->email, $user->name)
                    ->subject('Your Payment completed!')
                    ->bcc(getenv('EMAIL_RECEIVE_NOTICE'));
            });

        try{
            Slack::send($user->name.'('.$user->email.') paid '.$payment->amount.'€ !');
        }catch(\Exception $e){
            Bugsnag::notifyError('Slack endpoint problem fired for '.$user->name.' payment');
        }

    }
}
