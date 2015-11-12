<?php

Route::group(['prefix' => getenv('ADMIN_BASE_PATH'), 'middleware' => 'auth.basic'], function () {


    Route::get('/', [
      'as' => 'adcp.dashboard',
      function () {
          return view('adcp.dashboard')->with('payments', App\Payment::orderBy('id', 'desc')->paginate(25));
      }
    ]);

    Route::resource('payments', 'AdminPaymentsController');
    Route::resource('users', 'UserController');
});
