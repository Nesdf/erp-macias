<?php

namespace Modules\MgClientes\Providers;

use Illuminate\Support\ServiceProvider;

class MgClientesServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('mgclientes.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'mgclientes'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/mgclientes');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/mgclientes';
        }, \Config::get('view.paths')), [$sourcePath]), 'mgclientes');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/mgclientes');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'mgclientes');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'mgclientes');
        }
    }

    public function registerFactories()
    {
        $this->app->singleton(Factory::class, function () {
            return Factory::construct(__DIR__ . '/Database/factories');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
