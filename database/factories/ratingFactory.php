<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\Yoeunes\Rateable\Models\Rating::class, function (Faker $faker) {
    return [
        'value' => random_int(1,5),
        'rateable_type' => \App\Models\Product::class,
        'rateable_id' => random_int(1,10),
        'user_id' => random_int(1,10),
    ];
});
