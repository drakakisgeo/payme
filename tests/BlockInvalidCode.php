<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlockInvalidCode extends TestCase
{

    /**
     * @test
     */
    public function inform_user_for_invalid_paymentcode(){
        $this->visit('/payment/testing-wrong-code')
          ->see('This payment is not valid');
    }
}
