<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\willvincent\Rateable\Rating::class, function (Faker $faker) {
    return [
        'rating' => random_int(1,5),
        'rateable_type' => \App\Models\Product::class,
        'rateable_id' => array_rand(\App\Models\Product::pluck('product_id','product_id')->toArray()),
        'user_id' => array_rand(\App\User::pluck('user_id','user_id')->toArray()),
    ];
});
