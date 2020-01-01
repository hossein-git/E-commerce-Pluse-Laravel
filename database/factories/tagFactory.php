<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Tag::class, function (Faker $faker) {
    return [
        'tag_name' => $name = $faker->streetName,
        'tag_slug' => \Illuminate\Support\Str::slug($name)
    ];
});
