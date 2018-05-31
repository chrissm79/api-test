<?php

namespace App\Http\GraphQL\Connections;

use GraphQL\Type\Definition\ResolveInfo;

class UserTasks implements Connection
{
    /**
     * Get the name of the connection.
     * Note: Connection names must be unique
     *
     * @return string
     */
    public function name()
    {
        return 'UserTasks';
    }

    /**
     * Get name of connection.
     *
     * @return string
     */
    public function type()
    {
        return 'task';
    }

    /**
     * Available connection arguments.
     *
     * @return array
     */
    public function args()
    {
        return [];
    }

    /**
     * Resolve connection.
     *
     * @param  mixed  $parent
     * @param  array  $args
     * @param  mixed  $context
     * @param  ResolveInfo $info
     * @return mixed
     */
    public function resolve($user, array $args, $context, ResolveInfo $info)
    {
        // we have access to `getConnection` here because of the trait we added
        return $user->tasks()->getConnection($args);
    }
}