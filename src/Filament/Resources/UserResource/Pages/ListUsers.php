<?php

namespace LaravelTurbo\JetstreamTurbo\Filament\Resources\UserResource\Pages;

use LaravelTurbo\JetstreamTurbo\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    public static $resource = UserResource::class;
}
