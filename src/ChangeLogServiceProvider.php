<?php

namespace Mohkoma\ChangeLog;

use Illuminate\Support\ServiceProvider;

class ChangeLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/changelog.php' => config_path('changelog.php'),
            ], 'config');
        }

        $this->loadViewsFrom(__DIR__.'/resources/views', 'changelog');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/changelog.php', 'changelog');
    }
}