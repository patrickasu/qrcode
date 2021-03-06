<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
         factory('App\Models\User', 10)->create();
         factory('App\Models\Qrcode', 50)->create();
         factory('App\Models\Transaction', 50)->create();
         factory('App\Models\Account', 10)->create();
         factory('App\Models\AccountHistory', 50)->create();
         $this->call(RoleSeeder::class);
    }
}
