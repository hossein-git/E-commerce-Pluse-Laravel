<?php

namespace App\view\composer;


use App\Models\brand;
use App\Models\Category;
use App\Models\DetailsOrder;
use App\Models\Product;
use App\Models\Setting;
use function foo\func;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class frontComposer
{
    /**
     * put into the cache for front
     * @param View $view
     */
    public function compose(View $view)
    {
        //if cache has those keys continue if not put em in cache
        $brands = Cache::rememberForever('brands', function () {
            return brand::select(['brand_id', 'brand_slug', 'brand_name', 'brand_image'])->get();
        });
        $categories = Cache::rememberForever('categories', function () {
            return Category::whereIsRoot()->with('children')->get(['category_id', 'category_slug', 'category_name']);
        });
        $setting = Cache::rememberForever('setting', function () {
            return Setting::first();
        });

        $special_offers = Cache::rememberForever('special_offers', function () {
            return Product::where('is_off', 1)->orderBy('off_price','desc')->take(5)
                ->get(['product_slug', 'product_name', 'status',
                    'data_available', 'is_off', 'off_price', 'cover', 'sale_price', 'created_at']);
        });

        $popular_products = Cache::rememberForever('popular_products', function () {
            $popular_ids = DetailsOrder::select('product_id')->orderBy('product_id', 'desc')->distinct()->pluck('product_id')->take(5);
            return Product::findOrFail($popular_ids,
                ['product_slug', 'product_name', 'status',
                    'data_available', 'is_off', 'off_price', 'cover', 'sale_price', 'created_at']);
        });


        $view->with([
            'brands' => $brands,
            'categories' => $categories,
            'setting' => $setting,
            'special_offers' => $special_offers,
            'popular_products' => $popular_products,
        ]);
    }
}