<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        \Illuminate\Support\Facades\DB::table('roles')->insert([
            ['name' => 'admin' , 'description' => 'can do anything'],
            ['name' => 'employee' , 'description' => 'can edit and create products , add new brands and categories , manage comments'],
            ['name' => 'author' , 'description' => 'can create products , manage comments '],
        ]);
    }
}
