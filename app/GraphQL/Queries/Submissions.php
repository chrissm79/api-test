<?php

namespace App\GraphQL\Queries;

use App\Models\Image;
use App\Models\Slogan;
use Nuwave\Lighthouse\Support\Schema\GraphQLResolver;
use Illuminate\Auth\Access\AuthorizationException;

class Submissions extends GraphQLResolver
{

    public function resolve()
    {
        if(!$this->context || !$this->context->user){
            throw new AuthorizationException('Unauthorized');
            return null;
        }


        $images = Image::query()->select('id', 'filename as data');

        $slogans = Slogan::query()->select('id', 'slogan as data')
            ->union($images)
            ;

        error_log($slogans->toSql(), 3, '/tmp/debug.txt');

        return $slogans
            ->limit(10)
            ->get()
            ;
    }

    public function resolveType($value)
    {

        error_log("\n" . get_class($value), 3, '/tmp/debug.txt');
        if ($value instanceof Artwork) {
            return schema()->instance('Artwork');
        } else if ($value instanceof Image) {
            return schema()->instance('Image');
        } else if ($value instanceof Slogan) {
            return schema()->instance('Slogan');
        }

        return schema()->instance('Image');
    }

}