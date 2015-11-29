<?php

/**
 * Homepage
 */
Route::get('/', function () {
    return view('welcome');
});

/**
 * Get a specific Payment Task
 * Input variable 'payment' is generated in the before filter.
 */
Route::get('/payment/{paymentcode}', [
  'middleware' => 'validpayment',
  function ($paymentcode) {
      return view('paymentform')->with('payment', Input::get('payment'));
  }
]);

/**
 * Payment of the task
 */
Route::post('/checkout/{paymentcode}','PaymentsController@makePayment');

/**
 * Thank you for your payment
 */
Route::get('thankyou', ['as'=>'thankyou', function () {
    return view('thankyou');
}]);

/**
 * Customer page to see the payment links
 */
Route::get('myaccount', [
  'as'         => 'customer.dashboard',
  'middleware' => 'auth',
  'uses'       => 'PaymentsController@myAcount'
]);

/**
 * Clef routing
 */
include('clefRoutes.php');


/**
 * Admin pages routing
 */
include('adminRoutes.php');


/**
 * Testing Routing [Development only]
 */
if (App::environment() == 'local') {
    include('TestingRoutes.php');
}