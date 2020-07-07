<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$factory->define(App\Models\User::class, function (Faker $faker) {
    $passwordHash = Hash::make('secret');
  $rememberToken = Str::random(10); 
      return [
          'name' => $faker->name,
          'role_id' => $faker->numberBetween(1,4),
          'email' => $faker->unique()->safeEmail,
          'password' =>   $passwordHash, // secret
          'role_id'=> rand(1,4),
          'remember_token' => $rememberToken,
      ];
  });

// $factory->define(User::class, function (Faker $faker) {

//     return [
//         'name' => $faker->word,
//         'role_id' => $faker->randomDigitNotNull,
//         'email' => $faker->word,
//         'email_verified_at' => $faker->date('Y-m-d H:i:s'),
//         'password' => $faker->word,
//         'remember_token' => $faker->word,
//         'created_at' => $faker->date('Y-m-d H:i:s'),
//         'updated_at' => $faker->date('Y-m-d H:i:s')
//     ];
// });
