<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class giftCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\GiftCard::truncate();
        DB::table('check_gift')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(\App\Models\GiftCard::class,10)->create();
    }
}
