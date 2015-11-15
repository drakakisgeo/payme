<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthorizedpageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIfAccountPageIsProtectedAgainstGuests()
    {
        $this->visit('/myaccount')
                ->see('You need to be authorized');
    }

    public function testInvalidPaymentCode(){

        $this->visit('/payment/testing-wrong-code')
                ->see('This payment is not valid');
    }
}
