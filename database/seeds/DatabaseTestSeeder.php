<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');

        Model::unguard();

        putenv('APP_ENV=testing');
        putenv('DB_CONNECTION=api_testing');
        putenv('DB_TESTING_DATABASE=wyw_api_test');

        // Test OAuth seeder
        $this->call('TestOAuthSeeder');

        // Test User seeder
        $this->call('TestUserSeeder');

        // Test Room seeder
        $this->call('TestRoomSeeder');


        Model::reguard();
    }
}
