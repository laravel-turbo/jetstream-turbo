<?php

namespace LaravelTurbo\JetstreamTurbo\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;
use Laravel\Jetstream\Http\Livewire\UpdateTeamNameForm as JetstreamUpdateTeamNameForm;

class UpdateTeamNameForm extends JetstreamUpdateTeamNameForm
{
    /**
     * Inidicates which emitted events the component should listen for.
     *
     * @var array
     */
    protected $listeners = [
        'refresh-update-team-name-form' => '$refresh',
    ];

    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * Mount the component.
     *
     * @param  mixed  $team
     * @return void
     */
    public function mount($team)
    {
        $this->team = $team;

        $this->state = ['name' => $team->name];
    }

    /**
     * Update the team's name.
     *
     * @param  \Laravel\Jetstream\Contracts\UpdatesTeamNames  $updater
     * @return void
     */
    public function updateTeamName(UpdatesTeamNames $updater)
    {
        $this->resetErrorBag();

        $updater->update($this->user, $this->team, $this->state);

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('teams.update-team-name-form');
    }
}
