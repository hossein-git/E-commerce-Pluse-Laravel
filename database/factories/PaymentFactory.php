<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Payment;use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'user_id' => array_rand(\App\User::pluck('user_id','user_id')->toArray()),
        'order_id' => array_rand(\App\Models\Order::pluck('order_id','order_id')->toArray()),
        'status' => ($status = random_int(0,1)) ,
        'payment_status' =>$status == 0 ? 'Invalid' : 'Completed',
        'sub_total' => $faker->randomNumber(4)
    ];
});
