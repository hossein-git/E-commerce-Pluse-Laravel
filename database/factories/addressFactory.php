<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Address::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'state' => $faker->country,
        'city' => $faker->city,
        'area' => $faker->firstNameMale,
//        'avenue' ,
        'street' => $faker->streetName,
        'phone_number'=> $faker->phoneNumber,
        'postal_code' => $faker->postcode,
        'number' => $faker->numberBetween(1,99),
//        'addressable_id' => array_rand(\App\Models\Order::select('order_id')->get()->toArray()),
        'addressable_id' => (array_rand([1, 2, 3, 4, 5, 6, 7, 8, 9])),
        'addressable_type' => \App\Models\Order::class
    ];
});
