<?php

namespace LaravelTurbo\JetstreamTurbo;

use Illuminate\Support\Arr;
use Laravel\Jetstream\Features as JetstreamFeatures;

class Features extends JetstreamFeatures
{
    /**
     * Determine if the given feature is enabled.
     *
     * @param  string  $feature
     * @return bool
     */
    public static function enabled(string $feature)
    {
        return in_array($feature, config('jetstream-turbo.features', [])) || parent::enabled($feature);
    }

    /**
     * Determine if the feature is enabled and has a given option enabled.
     *
     * @param  string  $feature
     * @param  string  $option
     * @return bool
     */
    public static function optionEnabled(string $feature, string $option)
    {
        return static::enabled($feature) &&
               config("jetstream-turbo-options.{$feature}.{$option}") === true;
    }

    /**
     * Enable the teams feature.
     *
     * @param  array  $options
     * @return string
     */
    public static function teams(array $options = [])
    {
        if (! empty($options)) {
            config(['jetstream-turbo-options.teams' => $options]);
        }

        return 'teams';
    }

    /**
     * Determine if the application is using any team feature.
     *
     * @return bool
     */
    public static function hasTeamTransferFeature()
    {
        return static::optionEnabled(static::teams(), 'transfer');
    }

    /**
     * Determine if the application is using any team type feature.
     *
     * @return bool
     */
    public static function hasTeamTypeFeature()
    {
        return static::optionEnabled(static::teams(), 'type');
    }

    /**
     * Determine if the application is using system dashboard feature.
     *
     * @return bool
     */
    public static function hasSystemDashboardFeature()
    {
        return static::optionEnabled(static::teams(), 'system');
    }
}
