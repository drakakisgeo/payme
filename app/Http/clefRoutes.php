<?php

Route::get('user/login/callback', [
  'as'   => 'clef.handshake',
  'uses' => 'ClefController@handshake'
]);

Route::post('/logoutclef', [
  'as'   => 'clef.logout',
  'uses' => 'ClefController@logout'
]);