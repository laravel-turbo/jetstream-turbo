<?php

namespace LaravelTurbo\JetstreamTurbo\Providers;

use Filament\PluginServiceProvider;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\TeamResource;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\UserResource;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\Pages\ViewRecord;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\Pages\ListRecords;

class FilamentServiceProvider extends PluginServiceProvider
{
    protected  $pages = [
        //ViewRecord::class,
        //ListRecords::class
    ];

    protected  $resources = [
        TeamResource::class,
        UserResource::class,
    ];
}
