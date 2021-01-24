<?php

namespace LaravelTurbo\JetstreamTurbo\Tests\Fixtures;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Jetstream\HasTeams;

class User extends Authenticatable
{
    use HasTeams;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
