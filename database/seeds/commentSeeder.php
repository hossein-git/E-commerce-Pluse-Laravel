<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class commentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \Laravelista\Comments\Comment::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(\Laravelista\Comments\Comment::class,50)->create();
    }
}
