<?php

namespace LaravelTurbo\JetstreamTurbo\Models;

use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
        'properties' => 'array',
    ];

    protected $with = [
        'team_type'
    ];

    protected $appends = [
        'team_type'
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
