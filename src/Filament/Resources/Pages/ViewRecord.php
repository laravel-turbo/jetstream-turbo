<?php

namespace LaravelTurbo\JetstreamTurbo\Filament\Resources\Pages;

use Filament\Filament;
use Filament\Forms\HasForm;
use Filament\Resources\Forms\Form;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class ViewRecord extends Page
{
    use HasForm;

    public static $deleteButtonLabel = 'jetstream-turbo::resources/pages/view-record.buttons.delete.label';

    public static $deleteModalCancelButtonLabel = 'jetstream-turbo::resources/pages/view-record.modals.delete.buttons.cancel.label';

    public static $deleteModalConfirmButtonLabel = 'jetstream-turbo::resources/pages/view-record.modals.delete.buttons.confirm.label';

    public static $deleteModalDescription = 'jetstream-turbo::resources/pages/view-record.modals.delete.description';

    public static $deleteModalHeading = 'jetstream-turbo::resources/pages/view-record.modals.delete.heading';

    public $indexRoute = 'index';

    public $record;

    public static $view = 'jetstream-turbo::resources.pages.view-record';

    public function canDelete()
    {
        return Filament::can('delete', $this->record);
    }

    public function delete()
    {
        $this->authorize('delete');

        $this->callHook('beforeDelete');

        $this->record->delete();

        $this->callHook('afterDelete');

        $this->redirect($this->getResource()::generateUrl($this->indexRoute));
    }

    public static function getBreadcrumbs()
    {
        return [
            static::getResource()::generateUrl() => (string) Str::title(static::getResource()::getPluralLabel()),
        ];
    }

    public function getForm()
    {
        return static::getResource()::form(
            Form::make()
                ->context(static::class)
                ->model(static::getModel())
                ->record($this->record)
        );
    }

    public function isAuthorized()
    {
        return Filament::can('viewAny', $this->record);
    }

    public function mount($record)
    {
        $this->callHook('beforeFill');

        $model = static::getModel();

        $this->record = (new $model())->resolveRouteBinding($record);

        if ($this->record === null) {
            throw (new ModelNotFoundException())->setModel($model, [$record]);
        }

        $this->callHook('afterFill');
    }
}
