<?php

namespace lumen\extra\providers;

use Laravel\Lumen\Application;
use Illuminate\Support\ServiceProvider;
use lumen\extra\common\JwtAuthFactory;

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
            $secret = $app->make('config')
                ->get('app.key');
            $config = $app->make('config')
                ->get('jwt');

            return new JwtAuthFactory($secret, $config);
        });
    }
}
