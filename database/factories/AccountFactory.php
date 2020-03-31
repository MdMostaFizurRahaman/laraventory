<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account;
use App\Models\Client;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'client_id' => Client::first()->id,
        'account_name' => Str::title($faker->word),
        'account_number' => $faker->creditCardNumber,
        'opening_balance' => 100000,
        'balance' => 100000,
        'bank_id' => $faker->numberBetween(1, 10),
        'address' => $faker->address,
        'status' => 1,
    ];
});
