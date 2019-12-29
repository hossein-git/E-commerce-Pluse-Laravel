<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Attribute::class, function (Faker $faker) {
    return [
        'attr_name' => $faker->name,
        'product_id' => array_rand(\App\Models\Product::pluck('product_id','product_id')->toArray()) ,
    ];
});
