<?php

namespace LaravelTurbo\JetstreamTurbo\Actions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use LaravelTurbo\JetstreamTurbo\Contracts\TransfersTeams;
use LaravelTurbo\JetstreamTurbo\Events\TeamTransferred;

class TransferTeam implements TransfersTeams
{
    /**
     * Transfer the given app to the given team.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @param  \App\Models\User  $teamMember
     * @return void
     */
    public function transfer($user, $team, $teamMember)
    {
        $this->authorize($user, $team, $teamMember);

        $team->transfer($user, $teamMember);

        TeamTransferred::dispatch($team, $user, $teamMember);
    }

    /**
     * Authorize that the user can transfer team ownership to the team member.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  mixed  $teamMember
     * @return void
     */
    protected function authorize($user, $team, $teamMember)
    {
        if (! Gate::forUser($user)->check('transferTeam', $team) &&
            $user->id !== $teamMember->id) {
            throw new AuthorizationException;
        }
    }
}
