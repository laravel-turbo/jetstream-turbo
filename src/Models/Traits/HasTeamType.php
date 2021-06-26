<?php

namespace LaravelTurbo\JetstreamTurbo\Models\Traits;

use Laravel\Jetstream\Jetstream;

trait HasTeamType
{
    public function typeAlias()
    {
        return $this->slug;
    }

    public function typesAlias()
    {
        return Str::plural($this->slug);
    }

    public function type()
    {
        return $this->belongsTo(TeamType::class);
    }
}
