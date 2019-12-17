<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\Laravelista\Comments\Comment::class, function (Faker $faker) {
    return [
        'commenter_id' => array_rand(\App\User::pluck('user_id','user_id')->toArray()),
        'commenter_type' => \App\User::class,
        'commentable_type' => \App\Models\Product::class,
        'commentable_id' => random_int(1,10),
        'comment' => $faker->realText(50),
        'approved' => array_rand([0,1])
    ];
});
