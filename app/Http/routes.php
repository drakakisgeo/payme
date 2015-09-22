<?php

/**
 * Homepage
 */
Route::get('/', function () {
    return view('welcome');
});

/**
 * Thank you for your payment
 */
Route::get('thankyou', ['as'=>'thankyou',function () {
    return view('thankyou');
}]);

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


Route::get('myaccount', [
  'as'         => 'customer.dashboard',
  'middleware' => 'auth',
  'uses'       => 'PaymentsController@myAcount'
]);

include('clefRoutes.php');


// Admin routes
include('adminRoutes.php');


// Testing routes, only locally
if (App::environment() == 'local') {
    include('TestingRoutes.php');
}