<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;


$factory->define(\App\Models\Order::class, function (Faker $faker) {
    $id = (random_int(1,10));
    return [
        'user_id' => array_rand(\App\User::all()->pluck('user_id')->toArray()),
//        'user_id' => array_rand([1,2,null,4,6,5,7,8,null,9,3]),
//        'employee_id',
//        'payment_id' => array_rand([1, 2, 3, 4, 5, 6, 7, 8, 9]),
        'gift_id' => (\App\Models\GiftCard::findOrFail($id)->gift_id),
        'order_status' => array_rand([0, 1, 2]),
        'track_code' => $faker->numberBetween(10000000, 99999999),
        'client_name' => $faker->name,
        'client_phone' => $faker->phoneNumber,
        'total_price' => $faker->randomNumber(),
        'details' => $faker->realText(150)
    ];
});
