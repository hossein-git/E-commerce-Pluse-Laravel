<?php

namespace App\Http\Controllers\Front;

use App\Models\brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use PhpParser\Comment;

class homeController extends Controller
{
    private $product;

    public function __construct()
    {
        $this->middleware('web');
        $this->product = new Product();
    }

    /**
     * Home page
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
        $products = $this->product->select(['product_id', 'product_slug', 'product_name', 'status',
                'data_available', 'is_off', 'off_price', 'cover', 'sale_price', 'created_at']
        )->paginate(4);
        if ($request->ajax()) {
            $view = view('Front._data', compact('products'))->render();
            return response()->json(['html' => $view]);
        }
        //set cache to get the number of reviews on this page
        if (!Cache::has('homePage')) {
            (Cache::put('homePage', 1, 99999999));
        }
        //see how many times home page loaded
        Cache::increment('homePage');

        return view('Front.home', compact('products'));
    }

    /**
     * show product
     *
     * @param Request $request
     * @param string $slug
     * @param boolean $has_commented
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $this->validate($request, ['slug' => 'string']);
        $product = $this->product->where('product_slug', "$slug")->first();
        if (!$product){
            abort(404);
        }
        //GET RELATED TAGS
        $tag_slugs = $product->tags()->get(['tag_slug']);
        //PUSH TAGS INTO ONE ARRAY
        $slugs = [];
        foreach ($tag_slugs as $tag_slug) {
            array_push($slugs, $tag_slug->tag_slug);
        }
        //GET PRODUCTS WHICH HAS SAME TAG
        $related_products = $this->product->whereHas('tags', function ($query) use ($slugs) {
            return $query->whereIn('tag_slug', array_unique($slugs));
        })->get(['product_slug', 'product_name', 'status',
            'data_available', 'is_off', 'off_price', 'cover', 'sale_price', 'created_at'])->take(6);

        //check if auth user has commented for this products
        $has_commented = in_array(auth()->id(),$product->comments()->pluck('commenter_id','commenter_id')->toArray());

        return view('front.product.show', compact('product', 'related_products','has_commented'));
    }

    /**
     * get all products with filters
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function productsList(Request $request)
    {
        $this->inputs($request);
        $products = $this->product->orderBy("$request->sort", "$request->dcs")
            ->whereBetween('sale_price', [$request->priceMin, $request->priceMax])
            ->select(['product_id','product_slug', 'product_name', 'description', 'status',
                    'data_available', 'is_off', 'off_price', 'cover', 'sale_price', 'created_at']
            )->paginate($request->paginate);

        if ($request->ajax()) {
            $view = view('Front.listing._data', compact('products'))->render();
            return response()->json(['html' => $view]);
        }
        return view('Front.listing.list', compact('products'));
    }

    /**
     *   get products related to brands or categories OR TAGS
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, $list, $slug)
    {
        $this->validate($request, [
            'list' => ['sting'],
            'slug' => ['sting']
        ]);

        switch ($list) {
            case $list === 'categories':
                $model_slug = 'category_slug';
                break;

            case $list === 'brands':
                $model_slug = 'brand_slug';
                break;

            case $list === 'tags':
                $model_slug = 'tag_slug';
                break;
            //if $list is non of above then 404
            default:
                return redirect(404);
                break;
        }
        $this->inputs($request);
        $products = $this->product->whereHas("$list", function ($query) use ($slug, $model_slug) {
            return $query->where("$model_slug", "$slug");
        })->select(['product_slug', 'product_name', 'description', 'status',
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

    /**
     * SEARCH
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->validate($request, ['search' => 'required|string|max:35']);
        $query = $request->input('search');
        $products = [];
        if ($query) {
            /** IF USING ALOGRITA SEARCH SYSTEM UNCOMMENT BELOW AND COMMENT AFTER THAT **/
//                $products = $this->product->search($query)->paginate(10);
            $products = $this->product
                ->Where('product_name', 'like', '%' . $query . '%')
                ->select(['product_slug', 'product_name', 'status',
                    'data_available', 'is_off', 'off_price', 'cover', 'sale_price', 'created_at'])
                ->paginate(6);;
        }
//        if (\request()->ajax()) {
//            $view = view('Front.listing._data', compact('products'))->render();
//            return response()->json(['html' => $view]);
//        }
        return view('Front.search.search', compact('products'))->with(['query' => $request->input('search')]);

    }

    /**
     * search autoComplete
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function autoComplete(Request $request)
    {
        $this->validate($request, ['query' => 'string|max:35']);
        $products = $this->product->select(['product_name'])
            ->Where('product_name', 'LIKE', '%' . $request->input('query') . '%')->get();
        $data = [];
        foreach ($products as $product) {
            $data[] = $product->product_name;
        }
        return response()->json($data);
    }

    /**
     * track order
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function trackOrder(Request $request)
    {
        if ($request->input('input')) {
            abort(404);
        }
        if (ctype_digit($request->input('code'))) {
            $this->validate($request, ['code' => 'required|numeric|digits_between:8,8']);
            $orders = Order::where('track_code', 'LIKE', '%' . $request->input('code') . '%')->get();
            return view('Front.account.myOrders', compact('orders'))->with(['track' => true]);
        }
    }

    /**
     * compare 2 products
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function compare(Request $request)
    {
        $p_1 = null;
        $p_2 = null;

        if ($id1 = $request->cookie('P_compare_1')) {
            $p_1 = $this->product->findOrFail($id1, ['product_slug', 'brand_id', 'product_name', 'description', 'status',
                'data_available', 'is_off', 'off_price', 'cover', 'sale_price', 'created_at']);
        }
        if ($id2 = $request->cookie('P_compare_2')) {
            $p_2 = $this->product->findOrFail($id2, ['product_slug', 'brand_id', 'product_name', 'description', 'status',
                'data_available', 'is_off', 'off_price', 'cover', 'sale_price', 'created_at']);
        }
        return view('Front.product.compare', compact('p_1', 'p_2'));
    }

    /**
     * add to compare with cookie
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function compareProduct(Request $request)
    {
        $id = $request->input('id');
        if (ctype_digit($id)) {
            $name = 'P_compare_1';
            if ($request->cookie('P_compare_1')) {
                $name = 'P_compare_2';
            }
            return response()->json()->withCookie($name, $id, 10);
        }
    }

    /**
     * remove product from compare list
     *
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function removeCompare($name)
    {
        return response()->json(['success' => 'compare product has removed'])->withCookie(Cookie::forget("$name"));

    }

    /**
     * validate requests for isting products
     *
     * @param Request $request
     * @return $request
     */
    private function inputs($request)
    {
        $this->validate($request, [
            'sort' => ['string'],
            'dcs' => ['string'],
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

}
