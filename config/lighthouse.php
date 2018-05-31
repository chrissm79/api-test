<?php

return [

   /*
    |--------------------------------------------------------------------------
    | LightHouse endpoint & middleware
    |--------------------------------------------------------------------------
    |
    | Setup this values as required,
    | default route endpoints its yourdomain.com/graphql
    | setup middleware here for all request,
    | setup more endpoints, ej: pointing to the controller value inside your route file
    |
    */
    'route_name' => 'graphql',

    'route' => [
        'prefix' => '',
        'middleware' => [ 'auth:api', 'scopes:graphql' ], // [ 'auth:api', 'scopes:graphql' ],    // [ 'loghttp']
    ],


    /*
    |--------------------------------------------------------------------------
    | Directive registry
    |--------------------------------------------------------------------------
    |
    | This package allows you to create your own server-side directives. Change
    | these values to register the directory that will hold all of your
    | custom directives.
    |
    */
    'directives' => [__DIR__.'/../app/GraphQL/Directives'],

    /*
    |--------------------------------------------------------------------------
    | Namespace registry
    |--------------------------------------------------------------------------
    |
    | This package provides a set of commands to make it easy for you to
    | create new parts in your GraphQL schema. Change these values to
    | match the namespaces you'd like each piece to be created in.
    |
    */
    'namespaces' => [
        'models' => 'App\\Models',
        'mutations' => 'App\\GraphQL\\Mutations',
        'queries' => 'App\\GraphQL\\Queries',
        'types' => 'App\\GraphQL\\Types',
        'fields' => 'App\\GraphQL\\Fields',
        'scalars' => 'App\\GraphQL\\Scalars',
        'connections' => 'App\\GraphQL\\Connections',
        'dataloaders' => 'App\\GraphQL\\DataLoaders',
    ],

     /*
     |--------------------------------------------------------------------------
     | GraphQL Controller
     |--------------------------------------------------------------------------
     |
     | Specify which controller (and method) you want to handle GraphQL requests.
     |
     */
    'controller' => 'Nuwave\Lighthouse\Support\Http\Controllers\GraphQLController@query',

    /*
    |--------------------------------------------------------------------------
    | Schema Cache
    |--------------------------------------------------------------------------
    |
    | Specify where the GraphQL schema should be cached.
    |
    */
    'cache' => null,

    /*
    |--------------------------------------------------------------------------
    | Global ID
    |--------------------------------------------------------------------------
    |
    | When creating a GraphQL type that is Relay compliant, provide a named field
    | for the Node identifier.
    |
    */
    'global_id_field' => 'id',

    /*
    |--------------------------------------------------------------------------
    | Schema declaration
    |--------------------------------------------------------------------------
    |
    | This is a path that points to where your GraphQL schema is located
    | relative to the app path. You should define your entire GraphQL
    | schema in this file (additional files may be imported).
    |
    */
    'schema' => [
        'register' => base_path('app/GraphQL/schema.graphql'),
    ],

    'route_enable_get' => true,

];
