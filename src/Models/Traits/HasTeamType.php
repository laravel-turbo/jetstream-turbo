<?php

namespace LaravelTurbo\JetstreamTurbo\Models\Traits;

use Laravel\Jetstream\Jetstream;

trait HasTeamType
{
    public function typeAlias()
    {
        return $this->type->slug;
    }

    public function typesAlias()
    {
        return Str::plural($this->type->slug);
    }

    public function type()
    {
        return $this->belongsTo(JetstreamTurbo::teamTypeModel());
    }
}
