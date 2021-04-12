<?php

namespace LaravelTurbo\JetstreamTurbo\Filament\Resources\TeamResource\RelationManagers;

use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\RelationManager;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class UsersRelationManager extends RelationManager
{
    public static $primaryColumn = 'id';

    public static $relationship = 'users';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('name')->autofocus()->required(),
                Components\TextInput::make('email')->email()->required(),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
        ->columns([
            Columns\Text::make('name')
                ->searchable()
                ->sortable()
                ->primary(),
            Columns\Text::make('email')
                ->searchable()
                ->sortable()
                ->url(fn ($user) => "mailto:{$user->email}"),
        ]);
    }
}
