<?php

namespace App\Providers;

use Queue;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    //@TODO Remove me when a fix is implemented
    protected function loadRoutesFrom($location){
        return $location;
    }

}
