<?php

namespace LaravelTurbo\JetstreamTurbo\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\UserResource;

class CreateUser extends CreateRecord
{
    public static $resource = UserResource::class;
}
