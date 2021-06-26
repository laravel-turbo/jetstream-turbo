<?php

namespace LaravelTurbo\JetstreamTurbo\Models\Traits;

use LaravelTurbo\JetstreamTurbo\JetstreamTurbo;

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
