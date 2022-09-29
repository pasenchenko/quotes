<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Twig
        $loader = new \Twig\Loader\FilesystemLoader();
        $loader->addPath(base_path() . '/resources/views/components', 'components');
        $loader->addPath(base_path() . '/resources/views/layouts', 'layouts');
        \Twig::getLoader()->addLoader($loader);
    }
}