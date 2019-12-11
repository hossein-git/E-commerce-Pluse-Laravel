<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Photo::class, function (Faker $faker) {
    $photoable =[
        \App\Models\Product::class
    ];
//    $photoable_id = \App\Models\Product::all()->pluck('product_id')->toArray();
    return [
        'photo_title' => $faker->lastName,
        'src' => 'sample',
        'photo_size' => $faker->numberBetween(100,1000),
        'photo_type' => $faker->mimeType,
        'photoable_type' => array_rand($photoable),
        'photoable_id' => array_rand([1,2,3,4,5,6,7,8,9])
    ];
});
