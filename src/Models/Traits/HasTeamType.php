<?php

namespace LaravelTurbo\JetstreamTurbo\Models\Traits;

use LaravelTurbo\JetstreamTurbo\JetstreamTurbo;

trait HasTeamType
{
    public function typeAlias()
    {
        return $this->team_type?->slug;
    }

    public function typesAlias()
    {
        return Str::plural($this->team_type?->slug);
    }

    public function team_type()
    {
        return $this->belongsTo(JetstreamTurbo::teamTypeModel());
    }

    public function getTypeAttribute()
    {
        return $this->team_type?->slug;
    }
}
