<?php

namespace App\view\composer;


use App\Models\brand;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class frontComposer
{
    public function compose(View $view)
    {
        //if cache has those keys continue if not put em in cache
        $brands =  Cache::rememberForever('brands', function () {
            return brand::select(['brand_id', 'brand_slug', 'brand_name', 'brand_image'])->get();
        });
        $categories = Cache::rememberForever('categories', function () {
            return Category::whereIsRoot()->with('children')->get(['category_id', 'category_slug', 'category_name']);
        });

        $view->with([
            'brands' =>     $brands,
            'categories' => $categories
        ]);
    }
}