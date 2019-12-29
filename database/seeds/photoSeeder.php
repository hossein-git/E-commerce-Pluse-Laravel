<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class photoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Photo::truncate();
        factory(\App\Models\Photo::class,20)->create();
    }
}
