<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Client;
use App\Models\CostType;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(CostType::class, function (Faker $faker) {
    return [
        'client_id' => Client::first()->id,
        'name' => Str::title($faker->word),
        'description' => $faker->sentence(5),
    ];
});
