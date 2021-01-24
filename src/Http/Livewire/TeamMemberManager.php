<?php

namespace LaravelTurbo\JetstreamTurbo\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager as JetstreamTeamMemberManager;
use Laravel\Jetstream\InteractsWithBanner;
use Laravel\Jetstream\Jetstream;
use LaravelTurbo\JetstreamTurbo\Contracts\TransfersTeams;

class TeamMemberManager extends JetstreamTeamMemberManager
{
    use InteractsWithBanner;

    /**
     * Inidicates if the application is confirming a team transfer to a user.
     *
     * @var bool
     */
    public $confirmingTeamTransfer = false;

    /**
     * The ID of the team member the team is being transferred to.
     *
     * @var int|null
     */
    public $teamMemberIdForTransfer = null;

    /**
     * The user's current password.
     *
     * @var string
     */
    public $password = '';

    /**
     * Confirm that the team should be transferred to the give user.
     *
     * @param  int  $userId
     * @return void
     */
    public function confirmTeamTransfer($userId)
    {
        $this->resetErrorBag();

        $this->password = '';

        $this->dispatchBrowserEvent('confirming-transfer-team');

        $this->confirmingTeamTransfer = true;

        $this->teamMemberIdForTransfer = $userId;
    }

    /**
     * Transfer ownership of the team to a different team member.
     *
     * @param LaravelTurbo\JetstreamTurbo\Contracts\TransfersTeams  $transferrer
     * @return void
     */
    public function transferTeam(TransfersTeams $transferrer)
    {
        if (! Hash::check($this->password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);
        }

        $this->password = '';

        $teamMember = Jetstream::findUserByIdOrFail($this->teamMemberIdForTransfer);

        if (! $this->team->hasUser($teamMember)) {
            $this->dangerBanner('You cannot transfer team ownership to a user outside of this team.');

            $this->confirmingTeamTransfer = false;

            return;
        }

        $transferrer->transfer(
            $this->user,
            $this->team,
            $teamMember
        );

        $this->team->refresh();

        $this->confirmingTeamTransfer = false;

        $this->teamMemberIdForTransfer = null;

        $this->banner('Team transfer successful');

        return redirect()->route('teams.show', ['team' => $this->team]);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('teams.team-member-manager');
    }
}
