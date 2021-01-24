<?php

namespace LaravelTurbo\JetstreamTurbo\Http\Controllers\Inertia;

use Illuminate\Http\Request;
use LaravelTurbo\JetstreamTurbo\Contracts\TransfersTeams;
use LaravelTurbo\JetstreamTurbo\Actions\ValidateTeamTransfer;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Http\Controllers\Inertia\TeamController as JetstreamTeamController;

class TeamController extends JetStreamTeamController
{
    use RedirectsActions;

    /**
     * Show the team management screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Inertia\Response
     */
    public function show(Request $request, $teamId)
    {
        $team = Jetstream::newTeamModel()->findOrFail($teamId);

        if (Gate::denies('view', $team)) {
            abort(403);
        }

        return Jetstream::inertia()->render($request, 'Teams/Show', [
            'team' => $team->load('owner', 'users', 'teamInvitations'),
            'availableRoles' => array_values(Jetstream::$roles),
            'availablePermissions' => Jetstream::$permissions,
            'defaultPermissions' => Jetstream::$defaultPermissions,
            'permissions' => [
                'canAddTeamMembers' => Gate::check('addTeamMember', $team),
                'canDeleteTeam' => Gate::check('delete', $team),
                'canRemoveTeamMembers' => Gate::check('removeTeamMember', $team),
                'canUpdateTeam' => Gate::check('update', $team),
                'canTransferTeams' => Gate::check('trasnferTeam', $team)
            ],
        ]);
    }


    /**
     * Transfer the given team to a given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @param  int  $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transfer(Request $request, $teamId, $userId)
    {
        $team = Jetstream::newTeamModel()->findOrFail($teamId);

        app(ValidateTeamTransfer::class)->validate($request->user(), $team);

        $transferrer = app(TransfersTeams::class);

        $transferrer->transfer(
            $request->user(),
            $team,
            Jetstream::findUserByIdOrFail($request->user_id)
        );

        return back(303)->banner('Team transfer successful');
    }
}
