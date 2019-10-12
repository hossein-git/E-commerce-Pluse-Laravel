<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\Laravelista\Comments\Comment::class, function (Faker $faker) {
    return [
        'guest_name' => $faker->name,
        'guest_email' => $faker->email,
        'commentable_type' => \App\Models\Product::class,
        'commentable_id' => random_int(1,10),
        'comment' => $faker->realText(50),
        'approved' => array_rand([0,1])
    ];
});
