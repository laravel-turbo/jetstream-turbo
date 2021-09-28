<?php

namespace LaravelTurbo\JetstreamTurbo\Providers;

use Filament\PluginServiceProvider;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\Pages\ListRecords;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\Pages\ViewRecord;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\TeamResource;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\UserResource;

class FilamentServiceProvider extends PluginServiceProvider
{
    protected $pages = [
        //ViewRecord::class,
        //ListRecords::class
    ];

    protected $resources = [
        TeamResource::class,
        UserResource::class,
    ];

    protected function resources()
    {
        return config('jetstream-turbo.filament.default_resources', $this->resources);
    }
}
