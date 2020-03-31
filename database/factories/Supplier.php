<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Client;
use App\Models\Supplier;
use App\User;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
        'client_id' => Client::first()->id,
        'name' => $faker->name,
        'company' => $faker->word,
        'mobile' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->address,
        'city' => $faker->city,
        'country' => $faker->country,
        'opening_balance' => 0,
        'created_by' =>User::first()->id,
        'updated_by' =>User::first()->id,
        'deleted_by' =>User::first()->id,
    ];
});
