<?php

namespace App\GraphQL\Queries;

use Illuminate\Auth\Access\AuthorizationException;
//use Nuwave\Lighthouse\Support\Schema\GraphQLQuery;

class Viewers // extends GraphQLQuery
{

    public function resolve()
    {
//        var_dump(func_get_args());
//        die();
        if(!$this->context || !$this->context->user){
            throw new AuthorizationException('Unauthorized');
            return null;
        }
//        return $this->context->user;
    }

}
