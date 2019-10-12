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
        factory(\Yoeunes\Rateable\Models\Rating::class,10)->create();
    }
}
