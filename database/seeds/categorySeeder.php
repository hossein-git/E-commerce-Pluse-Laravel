<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 0 ; $i < 5  ; $i++ ){
            $names = [
                'Gear',
                'Clothing',
                'Shoes',
                'Diapering',
                'Feeding',
                'Bath',
                'Toys',
                'Nursery',
                'Household',
                'Grocery'
            ];
            $index = array_rand($names);

            $node = \App\Models\Category::create([
                'category_name' => $names[$index],
                'category_slug' => Str::slug(($i + 5).($names[$index])) ,
                'children' => [
                    [
                        'category_name' => $i .'ch'.$names[$index],
                        'category_slug' => Str::slug($i.($names[$index])),
                    ],
                ],
            ]);
        }
    }
}
