<?php

namespace App\Providers;

use App\Actions\JetstreamTurbo\TransferTeam;
use LaravelTurbo\JetstreamTurbo\JetstreamTurbo;
use LaravelTurbo\JetstreamTurbo\JetstreamTurboServiceProvider as ServiceProvider;

class JetstreamTurboServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        JetstreamTurbo::transferTeamsUsing(TransferTeam::class);
    }
}
