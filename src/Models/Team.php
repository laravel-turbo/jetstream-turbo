<?php

namespace LaravelTurbo\JetstreamTurbo\Models;

use Laravel\Jetstream\Team as JetstreamTeam;
use LaravelTurbo\JetstreamTurbo\Models\Traits\TransfersTeams;
use LaravelTurbo\JetstreamTurbo\Models\Traits\HasTeamType;

class Team extends JetstreamTeam
{
    use TransfersTeams;
    use HasTeamType;

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
     * Set the the team to be a system team.
     *
     * @return $this
     */
    public function makeSystemTeam()
    {
        return $this->properties(['system_team' => true])->save();
    }

    /**
     * Specify the plan's attributes.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function properties(array $properties)
    {
        $this->properties = array_merge($this->properties, $properties);

        return $this;
    }
}
