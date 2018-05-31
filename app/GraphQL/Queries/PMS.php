<?php

namespace App\GraphQL\Queries;

use App\User;
use Illuminate\Auth\Access\AuthorizationException;
//use Nuwave\Lighthouse\Support\Schema\GraphQLResolver;
use App\Models\Room\Room;

class PMS // extends GraphQLResolver
{

    public function rooms() {

        // query
        $roomsQuery = Room::query();

        $user = auth()->user();
        /* @var $user User */

        if(!($user instanceof User) || !$user->tokenCan('graphql')){
            throw new AuthorizationException('Unauthorized');
            return null;
        }

        // get current user's client location
        $locations = explode(',', $user->client->location);
        if (is_array($locations) && count($locations) > 0) {
            $roomsQuery->whereIn('location', $locations);
        }

        return $roomsQuery
            ->where('reference', 'NOT LIKE', '%9999')
            ->orderBy('lft')
            ->get()
            ;

    }


    public function comments() {

        error_log(print_r(func_get_args(), 1), 3, '/tmp/debug.txt');
//        var_dump(func_get_args());
//        die();

        // query
        $roomsQuery = Room::query();

        // get current user's client location
//        $locations = explode(',', $this->context->user->client->location);
//        if (is_array($locations) && count($locations) > 0) {
//            $roomsQuery->whereIn('location', $locations);
//        }

        return $roomsQuery
            ->where('reference', 'NOT LIKE', '%9999')
            ->orderBy('lft')
            ->get()
            ;

    }


}
