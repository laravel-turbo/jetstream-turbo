<?php

namespace App\Providers;

use App\Actions\JetstreamTurbo\TransferTeam;
use Illuminate\Support\ServiceProvider;
use LaravelTurbo\JetstreamTurbo\JetstreamTurbo;

class JetstreamTurboServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //JetstreamTurbo::aliasTeamAs('team');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JetstreamTurbo::transferTeamsUsing(TransferTeam::class);
    }
}
