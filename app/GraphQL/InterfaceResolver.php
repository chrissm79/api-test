<?php

namespace App\GraphQL;

class InterfaceResolver
{
    public function submission($value)
    {
        return isset($value->data['slogan'])
            ? schema()->instance('Slogan')
            : schema()->instance('Image');
    }
}
