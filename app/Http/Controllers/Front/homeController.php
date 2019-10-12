<?php

namespace App\Http\Controllers\Front;

use App\Models\brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Comment;

class homeController extends Controller
{
    private $data;
    private $product;

    public function __construct()
    {
        //VARIABLE TO TAKE PRODUCTS IN LAST WEEK FOR DISPLAYING -NEW- LABEL
//      $this->data = \Carbon\Carbon::today()->subDays(7);
        $this->product = new Product();
    }

    //use for lists
    private function inputs($request)
    {
        $this->validate($request, [
            'sort' => 'string',
            'dcs' => 'string',
            'paginate' => 'numeric',
            'priceMin' => 'nullable|numeric',
            'priceMax' => 'nullable|numeric',
        ]);
        //if we access to this with get request those var we need set them here
        if (!$request->priceMin) {
            $request->priceMin = 0;
        }
        if (!$request->priceMax) {
            $request->priceMax = 99999999;
        }
        if (!$request->sort) {
            $request->sort = 'product_id';
        }
        if (!$request->dcs) {
            $request->dcs = 'desc';
        }
        if (!$request->paginate) {
            $request->paginate = 6;
        }
        return $request;

    }

    //home page method
    public function home(Request $request)
    {
        $products = $this->product->select(['product_slug', 'product_name', 'description', 'status',
                'data_available', 'is_off', 'off_price', 'cover', 'sale_price', 'created_at']
        )->paginate(4);
        $brands = brand::select(['brand_slug', 'brand_name', 'brand_image'])->get();
        if ($request->ajax()) {
            $view = view('Front._data', compact('products'))->render();
            return response()->json(['html' => $view]);
        }
        return view('Front.home', compact('products', 'brands'));
    }

    public function show($slug)
    {
            $product = $this->product->with(['photos:src,photo_id','brands'])->where('product_slug',"$slug")->first();
            return view('front.product.show', compact('product'));
    }

    //get all products with filters
    public function productsList(Request $request)
    {
        $this->inputs($request);

        $products = $this->product->orderBy("$request->sort", "$request->dcs")
            ->whereBetween('sale_price', [$request->priceMin, $request->priceMax])
            ->select(['product_slug', 'product_name', 'description', 'status',
                    'data_available', 'is_off', 'off_price', 'cover', 'sale_price', 'created_at']
            )->paginate($request->paginate);

        if ($request->ajax()) {
            $view = view('Front.listing._data', compact('products'))->render();
            return response()->json(['html' => $view]);
        }
        return view('Front.listing.list', compact('products'));
    }

    //get products related to brands or categories
    public function list(Request $request, $list, $slug)
    {
        $this->validate($request, [
            'list' => 'sting',
            'slug' => 'sting',
        ]);
        switch ($list) {
            case $list === 'categories':
                $model_slug = 'category_slug';
                break;

            case $list === 'brands':
                $model_slug = 'brand_slug';
                break;
            //if $list is non of above then 404
            default:
                return redirect(404);
                break;
        }
        $this->inputs($request);
        $products = $this->product->whereHas("$list",function ($query) use ($slug,$model_slug) {
            return $query->where("$model_slug", "$slug");
        })->select(['product_slug','product_name', 'description', 'status',
            'data_available', 'is_off', 'off_price', 'cover', 'sale_price', 'created_at'])
            ->orderBy("$request->sort", "$request->dcs")
            ->whereBetween('sale_price', [$request->priceMin, $request->priceMax])
            ->paginate($request->paginate);
        if ($request->ajax()) {
            $view = view('Front.listing._data', compact('products'))->render();
            return response()->json(['html' => $view]);
        }
        return view('Front.listing.list', compact('products'));

    }
}
