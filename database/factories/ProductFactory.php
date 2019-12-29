<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(\App\Models\Product::class, function (Faker $faker){
    $brands = \App\Models\brand::pluck('brand_id','brand_id')->toArray();
    return [
        'product_name' => $name = ($faker->name),
        'product_slug' => Str::slug($name),
        'sku' => $faker->numberBetween(10000000,99999999),
        'brand_id' => array_rand($brands),
        'buy_price' => $faker->numberBetween(100,500),
        'status' => ($status = $this->faker->boolean() ? "1" : "0"),
        'data_available' => $status ? \Carbon\Carbon::now()->addDays(rand(1,10)) : null,
        'is_off' => ($is_off = $this->faker->boolean() ? "1" : "0"),
        'off_price' => $is_off ? $faker->numberBetween(10,100) : '0',
        'has_size' => $this->faker->boolean() ? "1" : "0",
        'sale_price' => $faker->numberBetween(600,10000),
        'made_in' => $faker->country,
        'quantity' => $faker->numberBetween(1,100),
        'weight' => $faker->numberBetween(1,10),
        'description' => $faker->text,
        'cover' => 'sample-pr.jpg'
    ];
});
