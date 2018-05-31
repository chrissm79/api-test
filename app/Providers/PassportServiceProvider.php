<?php

namespace App\Providers;

use Carbon\Carbon;
use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Auth\RequestGuard;
use Illuminate\Auth\Events\Logout;
use Laravel\Passport\Passport;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Guards\TokenGuard;
use Laravel\Passport\PassportServiceProvider as LaravelPassportServiceProvider;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;

class PassportServiceProvider extends LaravelPassportServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // override key path
        Passport::$keyPath = '/run/keys';

        parent::boot();
    }


    /**
     * Register the token guard.
     *
     * @return void
     */
    protected function registerGuard()
    {
        app('auth')->extend('passport', function ($app, $name, array $config) {
            return tap($this->makeGuard($config), function ($guard) {
                $this->app->refresh('request', $guard, 'setRequest');
            });
        });
    }

    /**
     * Make an instance of the token guard.
     *
     * @param  array  $config
     * @return \Illuminate\Auth\RequestGuard
     */
    protected function makeGuard(array $config)
    {
        return new RequestGuard(function ($request) use ($config) {
            return (new TokenGuard(
                $this->app->make(ResourceServer::class),
                app('auth')->createUserProvider($config['provider']),
                $this->app->make(TokenRepository::class),
                $this->app->make(ClientRepository::class),
                $this->app->make('encrypter')
            ))->user($request);
        }, $this->app['request']);
    }

    /**
     * Register the cookie deletion event handler.
     *
     * @return void
     */
    protected function deleteCookieOnLogout()
    {
        // never needed
//        $this->app['event']->listen(Logout::class, function () {
//            if ($this->app['request']->hasCookie(Passport::cookie())) {
//                $this->app['cookie']->queue($this->app['cookie']->forget(Passport::cookie()));
//            }
//        });
    }

}
