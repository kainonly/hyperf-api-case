<?php

namespace lumen\extra\jwt;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class JwtServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('jwt', function (Application $app) {
            $secret = $app->make('config')->get('app.key');
            $config = $app->make('config')->get('jwt');
            return new JwtAuthFactory($secret, $config);
        });
    }
}
