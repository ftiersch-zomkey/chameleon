<?php

/*
|--------------------------------------------------------------------------
| Chameleon routes
|--------------------------------------------------------------------------
|
| Here we register the routes that will be used to start and stop
| impersonating someone.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/ftiersch/chameleon/impersonate/{user}', ['uses' => 'Ftiersch\Chameleon\Controllers\ChameleonController@impersonate'])
        ->name('ftiersch.chameleon.impersonate')
        ->middleware('auth');

    Route::get('/ftiersch/chameleon/stop', ['uses' => 'Ftiersch\Chameleon\Controllers\ChameleonController@stopImpersonating'])
        ->name('ftiersch.chameleon.impersonate.stop')
        ->middleware('auth');

});
