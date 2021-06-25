<?php

namespace LaravelTurbo\JetstreamTurbo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;

class TeamType extends Model
{
    use HasFactory;
    use HasSlug;
    use HasTeamType

    protected $fillable = [
        'name'
    ];

    public function teams()
    {
        return $this->hasMany(Team::class, 'type_id');
    }
}
