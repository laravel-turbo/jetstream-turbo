<?php

namespace LaravelTurbo\JetstreamTurbo\Console;

use Illuminate\Console\Command;
use LaravelTurbo\JetstreamTurbo;

class SetSystemTeamCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jetstream-turbo:set_system_team {team}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set team as a system team for Jetstream Turbo';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        JetstreamTurbo::setSystemTeamAs($this->argument('team'));
    }
}
