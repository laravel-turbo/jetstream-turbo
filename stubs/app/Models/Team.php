<?php

namespace App\Models;

use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use LaravelTurbo\JetstreamTurbo\Models\Team as JetstreamTurboTeam;
use LaravelTurbo\JetstreamTurbo\Models\Traits\TransfersTeams;
use Parental\HasChildren;

class Team extends JetstreamTurboTeam
{
    use TransfersTeams;
    use HasChildren;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
        'properties' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'personal_team',
        'type',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    protected $childTypes = [

    ];
}
