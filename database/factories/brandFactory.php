<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(\App\Models\brand::class, function (Faker $faker) {
    return [
        'brand_name' => ($name = $faker->streetName.random_int(0,99)),
        'brand_slug' => Str::slug($name),
        'brand_image' => 'brand-sample.png',
        'brand_description' => $faker->realText(60),
    ];
});
