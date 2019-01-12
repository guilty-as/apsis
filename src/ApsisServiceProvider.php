<?php

namespace Guilty\Apsis;

use Illuminate\Support\ServiceProvider;

class ApsisServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('apsis.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'apsis');
        
        $this->app->singleton(Factory::class, function () {
            $apiKey = config('apsis.api_key');
            return Factory::create($apiKey);
        });

    }
}