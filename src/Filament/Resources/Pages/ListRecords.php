<?php

namespace LaravelTurbo\JetstreamTurbo\Filament\Resources\Pages;

use Filament\Filament;
use Filament\Resources\Pages\Page;
use Filament\Resources\Tables\RecordActions;
use Filament\Resources\Tables\Table;
use Filament\Tables\HasTable;
use Illuminate\Support\Str;

class ListRecords extends Page
{
    use HasTable;

    public static $createButtonLabel = 'filament::resources/pages/list-records.buttons.create.label';

    public $createRoute = 'create';

    public static $editRecordActionLabel = 'filament::resources/pages/list-records.table.recordActions.edit.label';

    public $filterable = true;

    public $pagination = true;

    public $recordRoute = 'view';

    public $searchable = true;

    public $sortable = true;

    public static $view = 'filament::resources.pages.list-records';

    public function canCreate()
    {
        return Filament::can('create', static::getModel());
    }

    public function canDelete()
    {
        return true;
    }

    public function canView()
    {
        return true;
    }

    public function canDeleteSelected()
    {
        return static::getModel()::find($this->selected)
            ->contains(function ($record) {
                return Filament::can('delete', $record);
            });
    }

    public function deleteSelected()
    {
        $this->authorize('delete');

        static::getModel()::destroy(
            static::getModel()::find($this->selected)
                ->filter(function ($record) {
                    return Filament::can('delete', $record);
                })
                ->map(fn ($record) => $record->getKey())
                ->toArray(),
        );

        $this->selected = [];
    }

    public function getTable()
    {
        return static::getResource()::table(
            Table::make()
                ->context(static::class)
                ->filterable($this->filterable)
                ->pagination($this->pagination)
                ->primaryColumnUrl(function ($record) {
                    return $this->getResource()::generateUrl(
                        $this->recordRoute,
                        ['record' => $record],
                    );
                })
                ->recordActions([
                    RecordActions\Link::make('view')
                        ->label(static::$editRecordActionLabel)
                        ->url(fn ($record) => $this->getResource()::generateUrl($this->recordRoute, ['record' => $record]))
                        ->when(fn ($record) => Filament::can('view', $record)),
                    RecordActions\Link::make('edit')
                        ->label(static::$editRecordActionLabel)
                        ->url(fn ($record) => $this->getResource()::generateUrl($this->recordRoute, ['record' => $record]))
                        ->when(fn ($record) => Filament::can('update', $record)),
                ])
                ->searchable($this->searchable)
                ->sortable($this->sortable),
        );
    }

    public static function getTitle()
    {
        if (property_exists(static::class, 'title')) {
            return static::$title;
        }

        return (string) Str::of(class_basename(static::getModel()))
            ->kebab()
            ->replace('-', ' ')
            ->plural()
            ->title();
    }

    public function isAuthorized()
    {
        return Filament::can('viewAny', static::getModel());
    }

    protected function viewData()
    {
        return [
            'records' => $this->getRecords(),
        ];
    }
}
