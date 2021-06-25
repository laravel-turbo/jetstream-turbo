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
     * The membership model that should be used by Jetstream.
     *
     * @var string
     */
    public static $teamTypeModel = 'App\\Models\\TeamType';

    /**
     * The alias used in the URI to describe teams.
     *
     * @var string
     */
    public static $teamAlias = 'team';

    /**
     * Get the name of the membership model used by the application.
     *
     * @return string
     */
    public static function teamTypeModel()
    {
        return static::$teamTypeModel;
    }

    /**
     * Specify the membership model that should be used by Jetstream.
     *
     * @param  string  $model
     * @return static
     */
    public static function useTeamTypeModel(string $model)
    {
        static::$teamTypeModel = $model;

        return new static;
    }

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

        return $team?->type()?->teamAlias() ?? static::$teamAlias;
    }

    /**
     * Get the string used to describe teams.
     *
     * @return string
     */
    public static function TeamsAlias($tema = null)
    {
        $alias = $team?->type()?->teamAlias() ?? static::$teamAlias;
        return Str::plural($alias);
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
