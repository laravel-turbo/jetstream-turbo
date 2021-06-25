<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\CurrentTeamController;
use Laravel\Jetstream\Http\Controllers\Livewire\ApiTokenController;
use Laravel\Jetstream\Http\Controllers\Livewire\PrivacyPolicyController;
use Laravel\Jetstream\Http\Controllers\Livewire\TeamController;
use Laravel\Jetstream\Http\Controllers\Livewire\TermsOfServiceController;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use Laravel\Jetstream\Http\Controllers\TeamInvitationController;
use Laravel\Jetstream\Jetstream;
use LaravelTurbo\JetstreamTurbo\Features;
use LaravelTurbo\JetstreamTurbo\JetstreamTurbo;
use LaravelTurbo\JetstreamTurbo\Models\TeamType;

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
        Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
        Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
    }

    Route::group(['middleware' => ['auth', 'verified']], function () {
        // User & Profile...
        Route::get('/user/profile', [UserProfileController::class, 'show'])
                    ->name('profile.show');

        // API...
        if (Jetstream::hasApiFeatures()) {
            Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
        }

        // Teams...
        if (Jetstream::hasTeamFeatures()) {
            if (Jetstream::hasTeamTypeFeatures()) {
                TeamType::all()->each(function ($type) {
                    Route::get('/'.$type->teamsAlias().'/create', [TeamController::class, 'create'])->name('teams.create');
                    Route::get('/'.$type->teamsAlias().'/{team}', [TeamController::class, 'show'])->name('teams.show');
                    Route::put('/'.$type->teamsAlias().'/current', [CurrentTeamController::class, 'update'])->name('current-team.update');
                });
            } else {
                Route::get('/'.JetstreamTurbo::teamsAlias().'/create', [TeamController::class, 'create'])->name('teams.create');
                Route::get('/'.JetstreamTurbo::teamsAlias().'/{team}', [TeamController::class, 'show'])->name('teams.show');
                Route::put('/'.JetstreamTurbo::teamsAlias().'/current', [CurrentTeamController::class, 'update'])->name('current-team.update');
            }

            Route::get('/'.JetstreamTurbo::teamsAlias().'/invitations/{invitation}', [TeamInvitationController::class, 'accept'])
                        ->middleware(['signed'])
                        ->name('team-invitations.accept');

            if (JetstreamTurbo::hasTeamTransferFeature()) {
                Route::post('/'.JetstreamTurbo::teamsAlias().'/{team}/transfer/{user}', [TeamController::class, 'transfer'])->name('teams.transfer');
            }
        }
    });
});
