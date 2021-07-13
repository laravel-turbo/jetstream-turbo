<?php

namespace LaravelTurbo\JetstreamTurbo;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Laravel\Jetstream\Jetstream;
use LaravelTurbo\JetstreamTurbo\Contracts\TransfersTeams;

class JetstreamTurbo extends Jetstream
{
    /**
     * Indicates if JetstreamTurbo routes will be registered.
     *
     * @var bool
     */
    public static $registersRoutes = true;

    /**
     * The alias used in the URI to describe teams.
     *
     * @var string
     */
    public static $teamAlias = 'team';

    /**
     * * Determine if the application is using the teams transfer feature.
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
    public static function TeamAlias($team = null)
    {
        return ($team != null) ? $team->type : static::$teamAlias;
    }

    /**
     * Get the string used to describe teams.
     *
     * @return string
     */
    public static function TeamsAlias($team = null)
    {
        return Str::plural(static::TeamAlias($team));
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

    /**
     * Set the string used to alias teams.
     *
     * @param  string  $class
     * @return void
     */
    public static function setSystemTeamAs($id)
    {
        if (Schema::hasTable(Jetstream::newTeamModel()->table)) {
            Jetstream::newTeamModel()->findOrFail($id)->makeSystemTeam();
        }
    }

    /**
     * * Determine if the application is using the system dashboard feature.
     *
     * @return bool
     */
    public static function hasSystemDashboardFeature()
    {
        return Features::hasSystemDashboardFeature();
    }

    /**
     * * Determine if the application is using the team type feature.
     *
     * @return bool
     */
    public static function hasTeamTypeFeature()
    {
        return Features::hasTeamTypeFeature();
    }

    /**
     * Configure Jetstream to not register its routes.
     *
     * @return static
     */
    public static function ignoreRoutes()
    {
        static::$registersRoutes = false;

        return new static;
    }
}
