<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
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
        Order::truncate();
        \App\Models\DetailsOrder::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $size = ['s', 'M', 'L', 'XL'];

        factory(Order::class, 20)->create()->each(
            function (Order $order) use ($size) {
                $p_id = (Product::pluck('product_id', 'product_id')->toArray());
                $product = Product::findOrFail(array_rand($p_id));
                $attr = $product->attributes->first();
                $color = $product->colors->first();
                \App\Models\DetailsOrder::create([
                    'order_id' => $order->order_id,
                    'product_id' => $product->product_id,
                    'product_slug' => $product->product_slug,
                    'attributes' => $attr ? $attr->attr_name  : null,
                    'product_price' => ($product->sale_price),
                    'quantity' => rand(1, 10),
                    'size' => $product->has_size == 1 ? Arr::random($size) : null,
                    'color' => $color ? $color->color_name : null,
                ]);
            });
    }
}
