<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ratingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \willvincent\Rateable\Rating::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(\willvincent\Rateable\Rating::class,30)->create();
    }
}
