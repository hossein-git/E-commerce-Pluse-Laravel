<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class attributeValueSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Models\Attribute_Value::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        factory(\App\Models\Attribute_Value::class,20)->create();
        /*$attributes_values = [1 , 2 , 100 , 52 , 1024 , 'yes' ];
        $attr_input = [];
        foreach ($attributes_values as $value) {
            array_push($attr_input,[
                'value' => $value,
                'attr_id' => \App\Models\Attribute::pluck('attr_id','attr_id'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
        DB::table('attribute_values')->insert($attr_input);*/
    }
}
