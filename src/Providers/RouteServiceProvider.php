<?php

namespace LaravelTurbo\JetstreamTurbo\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use LaravelTurbo\JetstreamTurbo\JetstreamTurbo;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        Route::impersonate();

        //if (JetstreamTurbo::$registersRoutes) {
            Route::group([
                'namespace' => 'LaravelTurbo\JetstreamTrubo\Http\Controllers',
                'domain' => config('jetstream.domain', null),
                'prefix' => config('jetstream.prefix', config('jetstream.path')),
            ], function () {
                $this->loadRoutesFrom(__DIR__.'/../../routes/'.config('jetstream.stack').'.php');
            });
        //}
    }
}
