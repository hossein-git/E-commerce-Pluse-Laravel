<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Tag::class, function (Faker $faker) {
    $name = $faker->streetName;
    return [
        'tag_name' => $name,
        'tag_slug' => \Illuminate\Support\Str::slug($name)
    ];
});
