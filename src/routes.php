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
    /**
     * This route can be used to start an impersonation.
     */
    Route::get('/ftiersch/chameleon/impersonate/{user}', ['uses' => 'Ftiersch\Chameleon\Controllers\ChameleonController@impersonate'])
        ->name('ftiersch.chameleon.impersonate')
        ->middleware('auth');

    /**
     * This route stops any active impersonation.
     */
    Route::get('/ftiersch/chameleon/stop', ['uses' => 'Ftiersch\Chameleon\Controllers\ChameleonController@stopImpersonating'])
        ->name('ftiersch.chameleon.impersonate.stop')
        ->middleware('auth');

});
