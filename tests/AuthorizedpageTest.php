<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthorizedpageTest extends TestCase
{
    /**
     * @test
     */
    public function account_page_protected_from_guests()
    {
        $this->visit('/myaccount')
                ->see('You need to be authorized');
    }
}
