<?php

use Illuminate\Database\Seeder;

class ratingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\willvincent\Rateable\Rating::class,10)->create();
    }
}
