<?php

namespace Logger\Providers;

use Logger\Console\Commands\CLoadActionLogs;
use Logger\Console\Commands\CLoadTestLogs;
use Logger\Console\Commands\CMigrateLogger;

use Illuminate\Support\ServiceProvider;

class LoggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register config
        $this->mergeConfigFrom(
            __DIR__.'/../../config/logger.php',
            'logger'
        );
    }

    public function boot()
    {
        // Register migration without publication
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');

        // Publisg config
        $this->publishes([
            __DIR__.'/../../config/logger.php' => config_path('logger.php'),
        ], 'logger-config');

        // Registret console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                CLoadActionLogs::class,
                CLoadTestLogs::class,
                CMigrateLogger::class
            ]);
        }
    }
}