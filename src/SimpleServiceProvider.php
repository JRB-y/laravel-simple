<?php

namespace Jrb\Simple;

use Illuminate\Support\ServiceProvider;

/**
 * Class SimpleServiceProvider
 * @package Jrb\Simple
 */
class SimpleServiceProvider extends ServiceProvider
{

    protected $commands = [
        'Jrb\Simple\Crud\Commands\SimpleCrud'
    ];
    /**
     * Boot the Service.
     *
     * Publish the Configuration and the Migrations
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Crud/stubs' => resource_path('views/simple/crud/stubs')
        ], 'simple-crud');
    }

    /**
     * Register the Service.
     *
     * Load the Helpers.
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }
}
