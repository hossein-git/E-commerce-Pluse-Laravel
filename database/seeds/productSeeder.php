<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class productSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Product::truncate();
        DB::table('category_product')->truncate();
        DB::table('color_product')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(\App\Models\Product::class,10)->create()->each(function (\App\Models\Product $products){
            // add category for products
            $category = \App\Models\Category::pluck('category_id')->toArray();
            $products->categories()->attach(\App\Models\Category::find(array_rand($category)));
            // add colors for products
            $colors = \App\Models\Color::all()->pluck('color_id')->toArray();
            $products->colors()->attach(\App\Models\Color::find(array_rand($colors)));
        });
    }
}
