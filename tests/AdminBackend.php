<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminBackend extends TestCase
{

    use DatabaseTransactions;

    public function setUp(){
        parent::setup();
        $this->adminUser = User::where('email',getenv('USER_EMAIL'))->first();
    }

    /** @test **/
    public function admin_must_be_logged_in_to_access()
    {
        $this->actingAs($this->adminUser)
                ->visit('/'.getenv('ADMIN_BASE_PATH'))
                ->see('Dashboard');
    }

    /** @test **/
    public function non_admin_cant_login_to_admin_area()
    {
        $randomUser = factory(User::class)->create();

        $this->actingAs($randomUser)
          ->visit('/'.getenv('ADMIN_BASE_PATH'))
          ->seePageIs('/');
    }



    /** @test **/
    public function clients_listing_is_ok()
    {
        $this->withoutMiddleware()->visit('/adcp/users')->assertResponseOk();
    }

    /** @test **/
    public function create_a_new_customer()
    {
        $this->actingAs($this->adminUser)->visit('/adcp/users/create')->assertResponseOk();
    }

    /** @test **/
    public function create_a_new_payment_link()
    {
        $this->actingAs($this->adminUser)->visit('/adcp/payments/create')->assertResponseOk();
    }

}
