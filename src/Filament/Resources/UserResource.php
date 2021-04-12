<?php

namespace LaravelTurbo\JetstreamTurbo\Filament\Resources;

use LaravelTurbo\JetstreamTurbo\Filament\Resources\UserResource\Pages;
use LaravelTurbo\JetstreamTurbo\Filament\Resources\UserResource\RelationManagers;
use LaravelTurbo\JetstreamTurbo\Filament\Roles;
use Laravel\Jetstream\Jetstream;
use Filament\NavigationItem;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;
use STS\FilamentImpersonate\Impersonate;

class UserResource extends Resource
{
    public static $icon = 'heroicon-o-user';

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
                                ->disabled(fn ($records) => !Filament::can('edit', $record))
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
        ])
        ->prependRecordActions([
            Impersonate::make()
        ]);
    }

    public static function relations()
{
    return [
        RelationManagers\TeamsRelationManager::class,
    ];
}

    public static function routes()
    {
        return [
            Pages\ListUsers::routeTo('/', 'index'),
            Pages\CreateUser::routeTo('/create', 'create'),
            Pages\EditUser::routeTo('/{record}/edit', 'edit'),
            Pages\ViewUser::routeTo('/{record}', 'view')
        ];
    }

    public static function authorization()
    {
        return [
            Roles\Admin::allow()->only(['viewAny'])
        ];
    }
}
