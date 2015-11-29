<?php

use App\Payment;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Lollypop\Traits\Mailcatcher;

class PaymentFormTest extends TestCase
{
    use DatabaseTransactions;
    use Mailcatcher;

    /**
     * @test
     */
    public function check_that_paymentform_works()
    {

        // Create a payment link
        $paymentlink = factory(Payment::class)->create();

        // Visit the link and it works fine
        $this->visit('/payment/'.$paymentlink->code)
                ->see($paymentlink->description);

        // Fill in the form [Braintree gateway]
        $this->post('/checkout/'.$paymentlink->code,[
                'payment_method_nonce'=>'fake-valid-nonce'
        ]);

        // Check Email alert
        $this->seeInLastEmail('Payment Completed');

        // Todo: Check Slack alert

        //  Todo: I see the thank you page
        // $this->seePageIs('/thankyou');


    }
}
