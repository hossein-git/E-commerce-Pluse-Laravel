<?php

namespace App\view\composer;


use App\Models\brand;
use App\Models\Category;
use Illuminate\Contracts\View\View;

class frontComposer
{
    public function compose(View $view)
    {
        $view->with([
            'brands' =>     brand::select(['brand_id','brand_slug', 'brand_name','brand_image'])->get(),
            'categories' => Category::whereIsRoot()->get(['category_id','category_slug', 'category_name'])
        ]);
    }
}