<?php

namespace Modules\MgProyectos\Providers;

use Illuminate\Support\ServiceProvider;

class MgProyectosServiceProvider extends ServiceProvider
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
            __DIR__.'/../Config/config.php' => config_path('mgproyectos.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'mgproyectos'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/mgproyectos');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/mgproyectos';
        }, \Config::get('view.paths')), [$sourcePath]), 'mgproyectos');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/mgproyectos');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'mgproyectos');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'mgproyectos');
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
