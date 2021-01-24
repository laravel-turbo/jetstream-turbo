<?php

namespace LaravelTurbo\JetstreamTurbo\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use LaravelTurbo\JetstreamTurbo\Features;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jetstream-turbo:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the components and resources for Jetstream Turbo';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Check if Jetstream has been installed.
        if (! file_exists(config_path('jetstream.php'))) {
            $this->warn('Jetstream hasn\'t been installed. This package requires Jetstream to be installed.');

            if ($this->ask('Do you want to install Jetstream? (yes/no)', 'no') !== 'yes') {
                return 0;
            }

            $stack = $this->choice('Which Jetstream stack do you prefer', ['livewire', 'inertia']);

            if (($useTeams = $this->ask('Will your application use teams? (yes/no)', 'no') === 'yes') === 'no') {
                $this->error('This package requires the Jetstream teams feature. Please enable this in the Jetstream config. ');

                return 0;
            }

            $this->callSilent('jetstream:install', ['stack' => $stack, '--teams' => $useTeams]);
        } else {
            $stack = config('jetstream.stack');
            $useTeams = Features::enabled('teams');
        }

        // Publish...
        $this->callSilent('vendor:publish', ['--tag' => 'jetstream-turbo-config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'jetstream-turbo-migrations', '--force' => true]);

        // Directories...
        (new Filesystem)->ensureDirectoryExists(app_path('Actions/JetstreamTurbo'));
        (new Filesystem)->ensureDirectoryExists(app_path('Policies'));

        // Service Providers...
        copy(__DIR__.'/../../stubs/app/Providers/JetstreamTurboServiceProvider.php', app_path('Providers/JetstreamTurboServiceProvider.php'));

        $this->installServiceProviderAfter('JetstreamServiceProvider', 'JetstreamTurboServiceProvider');

        copy(__DIR__.'/../../stubs/app/Actions/TransferTeam.php', app_path('Actions/JetstreamTurbo/TransferTeam.php'));

        // Install Stack...
        if ($stack === 'livewire') {
            $this->installLivewireStack($useTeams);
        } elseif ($stack === 'inertia') {
            $this->installInertiaStack($useTeams);
        }

        $this->line('');
        $this->info('JetstreamTurbo installed successfully.');
        $this->comment('Please execute "npm install && npm run dev" to build your assets.');
    }

    /**
     * Install the Livewire stack into the application.
     *
     * @return void
     */
    protected function installLivewireStack(string $useTeams)
    {
        // Directories...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Livewire'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/teams'));

        // Models...
        // copy(__DIR__.'/../../stubs/app/Models/User.php', app_path('Models/User.php'));

        // Single Blade Views...
        copy(__DIR__.'/../../stubs/livewire/resources/views/navigation-menu.blade.php', resource_path('views/navigation-menu.blade.php'));

        if ($useTeams) {
            // Models...
            copy(__DIR__.'/../../stubs/app/Models/Team.php', app_path('Models/Team.php'));
            copy(__DIR__.'/../../stubs/app/Actions/TransferTeam.php', app_path('Actions/JetstreamTurbo/TransferTeam.php'));

            // Single Blade Views...
            copy(__DIR__.'/../../stubs/livewire/resources/views/teams/team-member-manager.blade.php', resource_path('views/teams/team-transfer-form.blade.php'));
        }
    }

    /**
     * Install the Livewire stack into the application.
     *
     * @return void
     */
    protected function installInertiaStack(string $useTeams)
    {
        if ($useTeams) {
            copy(__DIR__.'/../../stubs/inertia/resources/js/Pages/Teams/TeamMemberManager.vue', resource_path('js/Pages/Teams/TeamMemberManger.vue'));
        }
    }

    /**
     * Install the service provider in the application configuration file.
     *
     * @param  string  $after
     * @param  string  $name
     * @return void
     */
    protected function installServiceProviderAfter($after, $name)
    {
        if (! Str::contains($appConfig = file_get_contents(config_path('app.php')), 'App\\Providers\\'.$name.'::class')) {
            file_put_contents(config_path('app.php'), str_replace(
                'App\\Providers\\'.$after.'::class,',
                'App\\Providers\\'.$after.'::class,'.
                PHP_EOL.
                '        // '.$name.' must come after '.$after.PHP_EOL.
                '        App\\Providers\\'.$name.'::class,',
                $appConfig
            ));
        }
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
