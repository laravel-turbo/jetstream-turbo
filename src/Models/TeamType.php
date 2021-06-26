<?php

namespace LaravelTurbo\JetstreamTurbo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\Jetstream;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class TeamType extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'name',
    ];

    public function teams()
    {
        return $this->hasMany(Jetstream::teamModel());
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
