<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => Str::random(10),
        'price' => $faker->randomFloat(2,1,100),
    ];
});