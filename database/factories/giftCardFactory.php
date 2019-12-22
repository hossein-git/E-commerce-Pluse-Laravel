<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\GiftCard::class, function (Faker $faker) {
    return [
        'gift_name' => $faker->streetName,
        'gift_code' => $faker->randomNumber(8),
        'status' => $faker->numberBetween(0,1),
        'gift_amount' => random_int(50,1000)
    ];
});
