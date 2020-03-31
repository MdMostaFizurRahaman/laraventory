<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Client;
use App\Models\Product;
use App\Models\Unit;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'client_id' => Client::first()->id,
        'name' => Str::title($faker->word),
        'code' => $faker->colorName,
        'sale_price' => $faker->numberBetween(500, 1000),
        'description' => $faker->sentence(5),
        'quantity' => 0,
        'opening_quantity' => 0,
        'alert_quantity' => 0,
        'vat' => 0,
        'unit_id' => Unit::first()->id,
        'category_id' => $faker->numberBetween(1, 10),
        'currency_id' => $faker->numberBetween(1, 10),
    ];
});
