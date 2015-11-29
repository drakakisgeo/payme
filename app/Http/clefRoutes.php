<?php

/**
 * Login
 */
Route::get('user/login/callback', [
  'as'   => 'clef.handshake',
  'uses' => 'ClefController@handshake'
]);


/**
 * Logout
 */
Route::post('/logoutclef', [
  'as'   => 'clef.logout',
  'uses' => 'ClefController@logout'
]);