<?php

namespace LaravelTurbo\JetstreamTurbo\Filament\Resources;

use LaravelTurbo\JetstreamTurbo\Filament\Resources\TeamResource\Pages;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\TeamResource\RelationManagers;
use LaravelTurbo\JetstreamTurbo\Filament\Roles;
use Filament\NavigationItem;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class TeamResource extends Resource
{
    public static $icon = 'heroicon-o-user-group';

    public static function form(Form $form)
    {
        return $form
        ->schema([
            Components\Tabs::make('Page')
                ->tabs([
                    Components\Tab::make(
                        __('Details'),
                        [
                            Components\TextInput::make('name')
                                ->disabled(),
                        ]
                    ),
                    Components\Tab::make(
                        'Billing',
                        [

                        ]
                    ),
                ]),
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

    public static function relations()
{
    return [
        RelationManagers\UsersRelationManager::class,
    ];
}

    public static function routes()
    {
        return [
            Pages\ListTeams::routeTo('/', 'index'),
            Pages\CreateTeam::routeTo('/create', 'create'),
            Pages\EditTeam::routeTo('/{record}/edit', 'edit')
        ];
    }

    public static function authorization()
    {
        return [
            Roles\Admin::allow()->only(['viewAny'])
        ];
    }
}
