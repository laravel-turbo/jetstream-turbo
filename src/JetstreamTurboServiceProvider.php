<?php

namespace LaravelTurbo\JetstreamTurbo;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Laravel\Jetstream;
use Laravel\Jetstream\Features;
use LaravelTurbo\JetstreamTurbo\Http\Livewire\DeleteTeamForm;
use LaravelTurbo\JetstreamTurbo\Http\Livewire\TeamMemberManager;
use LaravelTurbo\JetstreamTurbo\Http\Livewire\UpdateTeamNameForm;
use Livewire\Livewire;

class JetstreamTurboServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->afterResolving(BladeCompiler::class, function () {
            if (config('jetstream.stack') === 'livewire' && class_exists(Livewire::class)) {
                if (Features::hasTeamFeatures()) {
                    Livewire::component('teams.team-member-manager', TeamMemberManager::class);
                    Livewire::component('teams.delete-team-form', DeleteTeamForm::class);
                    Livewire::component('teams.update-team-name-form', UpdateTeamNameForm::class);
                }
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePublishing();
        $this->configureRoutes();
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
    }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */
    protected function configureRoutes()
    {
        if (JetstreamTurbo::$registersRoutes) {
            Route::group([
                'namespace' => 'LaravelTurbo\JetstreamTrubo\Http\Controllers',
                'domain' => config('jetstream.domain', null),
                'prefix' => config('jetstream.prefix', config('jetstream.path')),
            ], function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/'.config('jetstream.stack').'.php');
            });
        }
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
}
