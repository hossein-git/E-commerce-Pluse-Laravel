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
        DB::table('product_tags')->truncate();
        DB::table('category_product')->truncate();
        DB::table('color_product')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(\App\Models\Product::class,20)->create()->each(function (\App\Models\Product $products){
            // add tags for products
            $tags = \App\Models\Tag::pluck('tag_id','tag_id')->toArray();
            $products->tags()->attach((array_rand($tags)));

            // add category for products
            $category = \App\Models\Category::pluck('category_id','category_id')->toArray();
            $products->categories()->attach(array_rand($category));

            // add colors for products
            $colors = \App\Models\Color::pluck('color_id','color_id')->toArray();
            $products->colors()->attach(array_rand($colors));
        });
    }
}
