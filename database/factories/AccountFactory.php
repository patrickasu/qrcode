<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account;
use Faker\Generator as Faker;

$factory->define(App\Models\Account::class, function (Faker $faker) {
    
    $withdrawal_method = array('bank','paypal', 'stripe', 'paystack');
    $users = App\Models\User::pluck('id')->all();
    return [
        'user_id' => $faker->unique()->randomElement($users),
        'balance' => $faker->numberBetween(200,4000),
        'total_credit' => $faker->numberBetween(50,4000),
        'total_debit' => $faker->numberBetween(0,200),
        'withdrawal_method' => $withdrawal_method[rand(0,3)],
        'payment_email' => $faker->email,
        'bank_name' => $faker->word,
        'bank_branch' => $faker->state,
        'bank_account' => $faker->bankAccountNumber ,
        'applied_for_payout'=> $faker->numberBetween(0,1),
        'paid'=> $faker->numberBetween(0,1),
        'country'=> $faker->country,
        'other_details' => $faker->paragraph(4, true)

    ];
});

// $factory->define(Account::class, function (Faker $faker) {

//     return [
//         'user_id' => $faker->randomDigitNotNull,
//         'balance' => $faker->randomDigitNotNull,
//         'total_credit' => $faker->randomDigitNotNull,
//         'total_debit' => $faker->randomDigitNotNull,
//         'withdrawal_method' => $faker->word,
//         'payment_email' => $faker->word,
//         'bank_name' => $faker->word,
//         'bank_branch' => $faker->word,
//         'bank_account' => $faker->word,
//         'applied_for_payout' => $faker->randomDigitNotNull,
//         'paid' => $faker->randomDigitNotNull,
//         'last_date_applied' => $faker->word,
//         'last_date_paid' => $faker->word,
//         'country' => $faker->word,
//         'other_details' => $faker->text,
//         'deleted_at' => $faker->date('Y-m-d H:i:s'),
//         'created_at' => $faker->date('Y-m-d H:i:s'),
//         'updated_at' => $faker->date('Y-m-d H:i:s')
//     ];
// });

