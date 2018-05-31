<?php

namespace App\GraphQL\Queries;

use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Nuwave\Lighthouse\Support\Schema\GraphQLResolver;
use App\Models\Image;
use App\Models\Slogan;

class Search
{

    public function resolve()
    {
        return Image::query()->limit(5)->get();
    }


    public function resolveSearchableAttribute() {
        return schema()->instance('Image');
    }

    public function resolveType($value = null) {
        return schema()->instance('Image');
    }
}