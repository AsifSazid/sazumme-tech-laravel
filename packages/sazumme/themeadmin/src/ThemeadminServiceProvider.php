<?php

namespace Sazumme\Themeadmin;

use Illuminate\Support\ServiceProvider;

class themeadminServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'themeadmin');

        $this->publishes([
            __DIR__.'/../publishable/assets' => public_path('vendor/themeadmin'),
        ], 'public');
    }
}