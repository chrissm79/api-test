<?php

namespace App\Providers;

use Illuminate\Auth\Events\Authenticated;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Passport\Events\AccessTokenCreated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        'App\Events\ExampleEvent' => [
            'App\Listeners\ExampleListener',
        ],

        AccessTokenCreated::class => [
            'App\Listeners\AuthTokenListener',
        ],

        Authenticated::class => [
            'App\Listeners\AuthenticatedListener',
        ],

    ];


    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\UpdateWebsocketListener',
        'App\Listeners\ImageListener',
    ];

}
