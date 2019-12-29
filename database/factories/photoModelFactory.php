<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Photo::class, function (Faker $faker) {
    $photoable = \App\Models\Product::class;
    static $id = 1;
    return [
        'photo_title' => $faker->name,
        'src' => 'sample-pr.jpg',
        'photo_size' => $faker->numberBetween(100,1000),
        'photo_type' => $faker->mimeType,
        'photoable_type' => ($photoable),
        'photoable_id' => $id++
    ];
});
