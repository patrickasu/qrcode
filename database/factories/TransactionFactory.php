<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Transaction;
use Faker\Generator as Faker;

$factory->define(App\Models\Transaction::class, function (Faker $faker) {
  
    $status = array('completed', 'initiated', 'failed');
  
      return [
          'user_id' =>  function(){
              return App\Models\User::all()->random();
          },
          'qrcode_owner_id' =>  function(){
              return App\Models\User::all()->random();
          },
          'qrcode_id' =>  function(){
              return App\Models\Qrcode::all()->random();
          },
          'payment_method' => 'paystack/'.$faker->creditCardType,
          'amount' => $faker->numberBetween(200,4000),
          'status' => $status[rand(0,2)]
          
      ];
  });

// $factory->define(Transaction::class, function (Faker $faker) {

//     return [
//         'user_id' => $faker->randomDigitNotNull,
//         'qrcode_id' => $faker->randomDigitNotNull,
//         'qrcode_owner_id' => $faker->randomDigitNotNull,
//         'payment_method' => $faker->word,
//         'message' => $faker->text,
//         'amount' => $faker->randomDigitNotNull,
//         'status' => $faker->word,
//         'created_at' => $faker->date('Y-m-d H:i:s'),
//         'updated_at' => $faker->date('Y-m-d H:i:s')
//     ];
// });
