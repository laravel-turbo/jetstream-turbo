<?php

namespace LaravelTurbo\JetstreamTurbo\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\ListRecords;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\UserResource;
use STS\FilamentImpersonate\CanImpersonateUsers;

class ListUsers extends ListRecords
{
    use CanImpersonateUsers;

    public static $resource = UserResource::class;
}
