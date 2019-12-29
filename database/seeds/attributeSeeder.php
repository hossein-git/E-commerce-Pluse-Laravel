<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class attributeSeeder extends Seeder
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

        factory(\App\Models\Attribute::class,10)->create();


        /*$attributes = ['sort' , 'materials' , 'cpu' , 'age' , 'ram' , 'LED' ];
        $attr_input = [];
        foreach ($attributes as $attribute) {
            array_push($attr_input,[
                'attr_name' => $attribute,
                'product_id' => random_int(1,10),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
        DB::table('attributes')->insert($attr_input);*/
    }
}
