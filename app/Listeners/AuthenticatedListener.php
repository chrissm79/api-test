<?php

namespace App\Listeners;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Authenticated;


class AuthenticatedListener extends Listener
{

    /**
     * Update user last_request_at if authenticated
     *
     * @param Authenticated $event
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function handle(Authenticated $event) {

        /* @var $event->user App\User */
        User::query()->findOrFail($event->user->id)->update(['last_request_at' => Carbon::now()]);

    }


}