<?php

use Illuminate\Support\Facades\Route;
use LaravelTurbo\JetstreamTurbo\Http\Controllers\Inertia\TeamController;

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    Route::group(['middleware' => ['auth', 'verified']], function () {
        // Teams...
        if (Jetstream::hasTeamFeatures()) {
            Route::post('/teams/{team}/transfer/{user}', [TeamController::class, 'transfer'])->name('teams.transfer');
        }
    });
});
