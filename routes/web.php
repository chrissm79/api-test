<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->get('/graphiql', function() {
    return view()->make('graphiql');
});

$router->get('/schema.json', function () use ($router) {
    $schema = $router->app->make('graphql')->execute(file_get_contents(
        base_path('vendor/nuwave/lighthouse/assets/introspection-0.6.0.txt')));
    return response()->json($schema);
});
$router->post('/schema.json', function () use ($router) {
    $schema = $router->app->make('graphql')->execute(file_get_contents(
        base_path('vendor/nuwave/lighthouse/assets/introspection-0.6.0.txt')));
    return response()->json($schema);
});

$router->post('login', function() use ($router) {
    $request = $router->app->make('request');
    /* @var $request Illuminate\Http\Request */
    $credentials = array(
        'username' => $request->input("username"),
        'password' => $request->input("password")
    );
    return $router->app->make('App\Auth\Proxy')->attemptLogin($credentials);
});

$router->post('refresh', function() use ($router) {
    $request = $router->app->make('request');
    /* @var $request Illuminate\Http\Request */
    return $router->app->make('App\Auth\Proxy')->attemptRefresh($request->input('refresh_token'));
});

