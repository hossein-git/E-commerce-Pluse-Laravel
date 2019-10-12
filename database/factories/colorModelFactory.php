<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Color::class, function (Faker $faker) {
    return [
        'color_name' => $faker->safeColorName,
        'color_code' => $faker->hexColor,
    ];
});
