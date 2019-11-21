<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class orderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Order::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(\App\Models\Order::class,10)->create()->each(function (\App\Models\Order $order){
            $p_id = (\App\Models\Product::all()->pluck('product_id')->toArray())[rand(1,9)];
            $product = \App\Models\Product::findOrFail($p_id);
            \App\Models\DetailsOrder::create([
                'order_id' => $order->order_id ,
                'product_id' => $product->product_id,
                'product_slug' => $product->product_slug,
//                'product_attr_id',
                'product_price'=> ($product->sale_price),
                'quantity' => rand(1,10),
                'size' => array_rand(['s','M','L','XL']),
//                'color'
            ]);
        });
    }
}
