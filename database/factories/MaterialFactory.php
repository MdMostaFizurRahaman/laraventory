<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Material;
use Faker\Generator as Faker;
use App\Models\Unit;
use App\Models\Client;
use App\User;
use Illuminate\Support\Str;

$factory->define(Material::class, function (Faker $faker) {
    return [
        'name' => Str::title($faker->word),
        'description' => $faker->sentence,
        'opening_stock' => 0,
        'quantity' => 0,
        'alert_quantity' => 0,
        'unit_id' => Unit::first()->id,
        'category_id' => $faker->numberBetween(1, 10),
        'client_id' => Client::first()->id,
        'created_by' => User::first()->id,
    ];
});
