<?php

namespace LaravelTurbo\JetstreamTurbo;

use Filament\Filament;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Features;
use LaravelTurbo\JetstreamTurbo\Http\Livewire\DeleteTeamForm;
use LaravelTurbo\JetstreamTurbo\Http\Livewire\TeamMemberManager;
use LaravelTurbo\JetstreamTurbo\Http\Livewire\UpdateTeamNameForm;
use LaravelTurbo\JetstreamTurbo\Providers\FilamentServiceProvider;
use LaravelTurbo\JetstreamTurbo\Providers\RouteServiceProvider;
use Lab404\Impersonate\ImpersonateServiceProvider;
use Livewire\Component;
use Livewire\Livewire;
use ReflectionClass;
use Symfony\Component\Finder\SplFileInfo;

class JetstreamTurboServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Filament::ignoreMigrations();
        Jetstream::ignoreRoutes();

        $this->registerProviders();

        $this->app->afterResolving(BladeCompiler::class, function () {
            if (config('jetstream.stack') === 'livewire' && class_exists(Livewire::class)) {
                if (Features::hasTeamFeatures()) {
                    Livewire::component('teams.team-member-manager', TeamMemberManager::class);
                    Livewire::component('teams.delete-team-form', DeleteTeamForm::class);
                    Livewire::component('teams.update-team-name-form', UpdateTeamNameForm::class);
                }
            }
        });

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'jetstream-turbo');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePublishing();
        $this->configureCommands();
    }

    /**
     * Register the given component.
     *
     * @param  string  $component
     * @return void
     */
    protected function registerComponent(string $component)
    {
        Blade::component('jetstream-tubo::components.'.$component, 'jet-tubro'.$component);
    }

    protected function configurePublishing()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/jetstream-turbo.php' => config_path('jetstream-turbo.php'),
        ], 'jetstream-turbo-config');

        $this->publishes([
            __DIR__.'/../routes/'.config('jetstream.stack').'.php' => base_path('routes/jetstream-turbo.php'),
        ], 'jetstream-turbo-routes');

        $this->publishes([
            __DIR__.'/../database/migrations/2021_03_17_231900_add_properties_to_teams_table.php' => database_path('migrations/2021_03_17_231900_add_properties_to_teams_table.php'),
        ], 'jetstream-turbo-migrations');

    }

    /**
     * Configure the commands offered by the application.
     *
     * @return void
     */
    protected function configureCommands()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\InstallCommand::class,
        ]);
    }

    protected function registerProviders()
    {
        $this->app->register(RouteServiceProvider::class);

        if(JetstreamTurbo::hasSystemDashboarFeature()) {
            $this->app->register(FilamentServiceProvider::class);
            $this->app->register(ImpersonateServiceProvider::class);
        }
    }

}
