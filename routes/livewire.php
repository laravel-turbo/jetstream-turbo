<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Jetstream;
use LaravelTurbo\JetstreamTurbo\Http\Controllers\Livewire\TeamController;
use LaravelTurbo\JetstreamTurbo\JetstreamTurbo;
use LaravelTurbo\LaravelTurbo\Features;

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    Route::group(['middleware' => ['auth', 'verified']], function () {
        // Teams...
        if (Jetstream::hasTeamFeatures()) {
            Route::get('/'.JetstreamTurbo::teamsAlias().'/create', [TeamController::class, 'create'])->name('teams.create');
            Route::get('/'.JetstreamTurbo::teamsAlias().'/{team}', [TeamController::class, 'show'])->name('teams.show');
            Route::put('/'.JetstreamTurbo::teamsAlias().'/current', [CurrentTeamController::class, 'update'])->name('current-team.update');

            Route::get('/'.JetstreamTurbo::teamsAlias().'/invitations/{invitation}', [TeamInvitationController::class, 'accept'])
                        ->middleware(['signed'])
                        ->name('team-invitations.accept');

            if (JetstreamTurbo::hasTeamTransferFeature()) {
                Route::post('/'.JetstreamTurbo::teamsAlias().'/{team}/transfer/{user}', [TeamController::class, 'transfer'])->name('teams.transfer');
            }
        }
    });
});
