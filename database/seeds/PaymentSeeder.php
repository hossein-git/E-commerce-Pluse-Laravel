<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Models\Attribute::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        factory(\App\Models\Payment::class,5)->create();
    }
}
