<?php

namespace LaravelTurbo\JetstreamTurbo;

use Illuminate\Support\Str;
use Laravel\Jetstream\Jetstream;
use LaravelTurbo\JetstreamTurbo\Contracts\TransfersTeams;

class JetstreamTurbo extends Jetstream
{
    /**
     * The alias used in the URI to describe teams.
     *
     * @var string
     */
    public static $teamAlias = 'team';

    /**
     * Determine if the application is using the teams transfer feature confirmation feature.
     *
     * @return bool
     */
    public static function hasTeamTransferFeature()
    {
        return Features::hasTeamTransferFeature();
    }

    /**
     * Register a class / callback that should be use to transfer teams.
     *
     * @param  string  $class
     * @return void
     */
    public static function transferTeamsUsing(string $class)
    {
        return app()->singleton(TransfersTeams::class, $class);
    }

    /**
     * Get the string used to describe a team.
     *
     * @return string
     */
    public static function TeamAlias()
    {
        return static::$teamAlias;
    }

    /**
     * Get the string used to describe teams.
     *
     * @return string
     */
    public static function TeamsAlias()
    {
        return Str::plural(static::$teamAlias);
    }

    /**
     * Set the string used to alias teams.
     *
     * @param  string  $class
     * @return void
     */
    public static function aliasTeamAs(string $alias)
    {
        static::$teamAlias = $alias;
    }
}
