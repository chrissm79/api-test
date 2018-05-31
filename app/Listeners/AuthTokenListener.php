<?php

namespace App\Listeners;

use App\Models\User;
use Carbon\Carbon;
use Laravel\Passport\Events\AccessTokenCreated;

class AuthTokenListener extends Listener
{

    /**
     * Update user last_login_at if token successfully created
     *
     * @param AccessTokenCreated $event
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function handle(AccessTokenCreated $event) {

        User::query()->findOrFail($event->userId)->update(['last_login_at' => Carbon::now()]);

    }

}