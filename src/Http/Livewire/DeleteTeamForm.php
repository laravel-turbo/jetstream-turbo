<?php

namespace LaravelTurbo\JetstreamTurbo\Http\Livewire;

use Laravel\Jetstream\Http\Livewire\DeleteTeamForm as JetstreamDeleteTeamForm;

class DeleteTeamForm extends JetstreamDeleteTeamForm
{
    /**
     * Inidicates which emitted events the component should listen for.
     *
     * @var array
     */
    protected $listeners = [
        'refresh-delete-team-form' => '$refresh',
    ];
}
