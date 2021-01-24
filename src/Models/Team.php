<?php

namespace LaravelTurbo\JetstreamTurbo\Models;

use Laravel\Jetstream\Team as JetstreamTeam;
use LaravelTurbo\JetstreamTurbo\Models\Traits\TransfersTeams;

class Team extends JetstreamTeam
{
    use TransfersTeams;
}
