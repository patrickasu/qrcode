<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use Carbon\Carbon;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Kelly Obi',
            'role_id' => 1,
            'email' => 'max@gmail.com',
            'password' => Hash::make('1111111111'),
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);
        DB::table('users')->insert([
            'name' => 'Daniel Sampson',
            'role_id' => 4,
            'email' => 'daniel@gmail.com',
            'password' => Hash::make('1111111111'),
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);
    }
}
