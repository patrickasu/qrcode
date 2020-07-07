<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Qrcode;
use Faker\Generator as Faker;

$factory->define(App\Models\Qrcode::class, function (Faker $faker) {
    return [
        'product_name' => $faker->sentence(rand(2, 1) , true),
        'company_name' => $faker->name,
        'website' => $faker->url,
        'callback_url' => $faker->url,
        'qrcode_path' => 'myqrcode/1.png',
        'amount' => rand(100,4000),
        'status' => rand(0,1),
        'user_id' =>  function(){
                            return App\Models\User::all()->random();
                        },
    ];
});

// $factory->define(Qrcode::class, function (Faker $faker) {

//     return [
//         'user_id' => $faker->randomDigitNotNull,
//         'website' => $faker->word,
//         'company_name' => $faker->word,
//         'product_name' => $faker->word,
//         'product_url' => $faker->word,
//         'callback_url' => $faker->word,
//         'qrcode_path' => $faker->word,
//         'amount' => $faker->randomDigitNotNull,
//         'status' => $faker->word,
//         'created_at' => $faker->date('Y-m-d H:i:s'),
//         'updated_at' => $faker->date('Y-m-d H:i:s')
//     ];
// });
