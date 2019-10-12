<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class addressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Address::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        factory(\App\Models\Address::class,20)->create();
    }
}
