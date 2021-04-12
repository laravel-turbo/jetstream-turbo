<?php

namespace LaravelTurbo\JetstreamTurbo\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\ListRecords;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\UserResource;

class ListUsers extends ListRecords
{
    public static $resource = UserResource::class;
}
