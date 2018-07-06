<?php

namespace Parserbin\Providers;

use Illuminate\Support\ServiceProvider;
use Parserbin\Services\ParserService;

class ParserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ParserService::class, function ($app) {
            return new ParserService();
        });
    }

    public function provides()
    {
        return [ParserService::class];
    }
}
