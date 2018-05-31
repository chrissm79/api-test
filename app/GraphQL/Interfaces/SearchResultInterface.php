<?php

namespace App\GraphQL\Interfaces;

use App\Models\Artwork;
use App\Models\Image;
use App\Models\Slogan;
use GraphQL\Type\Definition\Type;

class SearchResultInterface
{
    public function resolveType($value)
    {

        error_log("\nsfsefes" . get_class($value) . print_r($value->toArray(), 1), 3, '/tmp/debug.txt');

        if ($value instanceof Artwork) {
            return schema()->instance('Artwork');
        } else if ($value instanceof Image) {
            return schema()->instance('Image');
        } else if ($value instanceof Slogan) {
            return schema()->instance('Slogan');
        }

//        return schema()->instance('Image');
    }

}
