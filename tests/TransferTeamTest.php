<?php

namespace LaravelTurbo\JetstreamTurbo\Tests;

use App\Models\Team;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use LaravelTurbo\JetstreamTurbo\Actions\TransferTeam;
use LaravelTurbo\JetstreamTurbo\Actions\ValidateTeamTransfer;
use LaravelTurbo\JetstreamTurbo\Tests\Fixtures\Membership;
use LaravelTurbo\JetstreamTurbo\Tests\Fixtures\TeamPolicy;
use LaravelTurbo\JetstreamTurbo\Tests\Fixtures\User;
use Laravel\Jetstream\Jetstream;

class TransferTeamTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Gate::policy(Team::class, TeamPolicy::class);
        Jetstream::useUserModel(User::class);
        Jetstream::useMembershipModel(Membership::class);
    }

    public function test_team_can_be_transferred()
    {
        $this->migrate();

        $team = $this->createTeam();

        $team->users()->attach($otherUser = User::forceCreate([
            'name' => 'Adam Wathan',
            'email' => 'adam@laravel.com',
            'password' => 'secret',
        ]), ['role' => 'admin']);

        $action = new TransferTeam;

        $action->transfer($team->owner, $team, $otherUser);

        $this->assertEquals($otherUser->id, $team->owner->id);
    }

    public function test_team_transfer_can_be_validated()
    {
        $this->migrate();

        $team = $this->createTeam();

        $action = new ValidateTeamTransfer;

        $action->validate($team->owner, $team);

        $this->assertTrue(true);
    }

    public function test_personal_team_cant_be_transferred()
    {
        $this->expectException(ValidationException::class);

        $this->migrate();

        $team = $this->createTeam();

        $team->forceFill(['personal_team' => true])->save();

        $action = new ValidateTeamTransfer;

        $action->validate($team->owner, $team);
    }

    public function test_non_owner_cant_transfer_team()
    {
        $this->expectException(AuthorizationException::class);

        Jetstream::useUserModel(User::class);

        $this->migrate();

        $team = $this->createTeam();

        $action = new ValidateTeamTransfer;

        $action->validate(User::forceCreate([
            'name' => 'Adam Wathan',
            'email' => 'adam@laravel.com',
            'password' => 'secret',
        ]), $team);
    }

    protected function createTeam()
    {
        $user = User::forceCreate([
            'name' => 'Taylor Otwell',
            'email' => 'taylor@laravel.com',
            'password' => 'secret',
        ]);

        return $user->ownedTeams()->create([
            'name' => 'Test Team',
            'personal_team' => false,
        ]);
    }

    protected function migrate()
    {
        $this->artisan('migrate', ['--database' => 'testbench'])->run();
    }
}
