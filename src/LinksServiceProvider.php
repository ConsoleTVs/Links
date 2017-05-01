<?php

namespace ConsoleTVs\Links;

use Illuminate\Support\ServiceProvider;
use ConsoleTVs\Charts\ChartsServiceProvider;
use Unicodeveloper\Identify\IdentifyServiceProvider;

class LinksServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        $this->publishes([
            __DIR__.'/Config/links.php' => config_path('links.php'),
        ], 'links_config');

        $router->aliasMiddleware('links.middleware', config('links.middleware'));

        $this->app->register(IdentifyServiceProvider::class);
        $this->app->register(ChartsServiceProvider::class);

        $this->loadViewsFrom(__DIR__.'/Views', 'links');

        $this->loadMigrationsFrom(__DIR__.'/Migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/Config/links.php', 'links');
    }
}
