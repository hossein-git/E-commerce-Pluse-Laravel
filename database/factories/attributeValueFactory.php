<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Attribute_Value::class, function (Faker $faker) {
    return [
        'value' => 'val->'.$faker->name('female'),
        'attr_id' => array_rand(\App\Models\Attribute::pluck('attr_id','attr_id')->toArray()),
    ];
});
