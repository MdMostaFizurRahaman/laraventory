<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductCategory;
use App\Models\Client;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ProductCategory::class, function (Faker $faker) {
    return [
        'name' => Str::title($faker->word),
        'description' => $faker->sentence,
        'client_id' => Client::first()->id
    ];
});
