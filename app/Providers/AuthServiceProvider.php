<?php

namespace App\Providers;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Dusterio\LumenPassport\LumenPassport;
use Laravel\Passport\Passport;
// use Illuminate\Support\Facades\Gate;
//use Illuminate\Auth\AuthServiceProvider;


class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.
        LumenPassport::routes($this->app, ['prefix' => 'oauth']);
        LumenPassport::allowMultipleTokens();
        LumenPassport::tokensExpireIn(Carbon::now()->addHours(2));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(60));


        // Gates
        // Gate::define('update-post', function ($user, $post) {
        //     return $user->id === $post->user_id;
        // }); // if (Gate::allows('update-post', $post)) {

        // Policies
        // Gate::policy(Post::class, PostPolicy::class);

        app()->configure('secrets');
        Passport::tokensCan(app('config')->get('secrets.scopes'));

    }
}
