<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

//$app->withFacades();
$app->withEloquent();

//class_alias('\Nuwave\Lighthouse\Support\Facades\GraphQLFacade', 'GraphQL');

/*
|--------------------------------------------------------------------------
| Load configuration files.
|--------------------------------------------------------------------------
|
|
*/

$app->configure('app');
$app->configure('auth');
$app->configure('cors');
$app->configure('lighthouse');
//$app->configure('lighthouse_subscriptions');
$app->configure('status_codes');


/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/


$app->middleware([
//    \App\Http\Middleware\Throttle::class,
    \Nord\Lumen\Cors\CorsMiddleware::class,
]);

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'scopes' => Laravel\Passport\Http\Middleware\CheckScopes::class,
    'scope' => Laravel\Passport\Http\Middleware\CheckForAnyScope::class,
    'cors' => \Nord\Lumen\Cors\CorsMiddleware::class,
]);

if (!function_exists('config_path')) {
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}
if (!function_exists('app_path')) {
    function app_path($path = '')
    {
        return app()->basePath() . '/app' . ($path ? '/' . $path : $path);
    }
}
/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/


$app->register(\App\Providers\AppServiceProvider::class);
$app->register(\App\Providers\AuthServiceProvider::class);
$app->register(\App\Providers\EventServiceProvider::class);
$app->register(\App\Providers\PassportServiceProvider::class);
$app->register(\Dusterio\LumenPassport\PassportServiceProvider::class);
$app->register(\Nord\Lumen\Cors\CorsServiceProvider::class);
$app->register(\Illuminate\Redis\RedisServiceProvider::class);
$app->register(\Illuminate\Broadcasting\BroadcastServiceProvider::class);
$app->register(\Nuwave\Lighthouse\Providers\LighthouseServiceProvider::class);
//$app->register(\Nuwave\Lighthouse\Subscriptions\SubscriptionServiceProvider::class);

if ($app->environment() != 'testing') {
    // $app->configure('gateway');
}


if ($app->environment() == 'debug') {
    $app->register(Laravel\Tinker\TinkerServiceProvider::class);
    $app->register(Appzcoder\LumenRoutesList\RoutesCommandServiceProvider::class);
}



/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
