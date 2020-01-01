<?php

namespace App\Http\Controllers\ADmin;

use App\Http\Requests\productRequest;
use App\Models\brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class productController extends Controller
{
    private $product;
    private $category;
    private $paginate;
    private $cachKey;

    public function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);

        $this->product = new Product();
        $this->category = new Category();
        $this->paginate = 10;
        $this->cachKey = 'products';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->with(['categories', 'colors'])->paginate($this->paginate);
        $index_categories = Category::select(['category_slug', 'category_name'])->get();
        return view('admin.products.index', compact('products', 'index_categories'));
    }

    //take trash products
    public function withTrash()
    {
        $products = $this->product::onlyTrashed()->with(['categories', 'colors'])->paginate($this->paginate);
        return view('admin.products.index', compact('products'));
    }

    //sort and listing products
    public function sort(Request $request)
    {
        $this->validate($request, [
            'sort' => 'string|required',
            'sort_category' => 'string|nullable',
            'dcs' => 'string|required',
        ]);
        $index_categories = true;
        $query = $this->product;
        if ($request->status) {
            $query = $this->product->where('status', 1);
        }
        if ($cat_slug = $request->sort_category) {
            $products = $query->whereHas("categories", function ($query) use ($cat_slug) {
                return $query->where('category_slug', $cat_slug);
            })->orderBy("$request->sort", "$request->dcs")->paginate($this->paginate);

        } else {
            $products = $query->orderBy("$request->sort", "$request->dcs")->paginate($this->paginate);
        }
        if ($request->ajax()) {
            $view = view('admin.products._data', compact('products','index_categories'))->render();
            return response()->json(['html' => $view]);
        }
        // this var provide to display 'restore' icon
        return view('admin.products.index', compact('products','index_categories'));
    }


    //Route : $this->product/index/restore name:$this->product.restore
    public function restore($id)
    {
        if (ctype_digit($id)) {
            $product = $this->product::withTrashed()->findOrFail($id)->restore();
            if ($product) {
                return response()->json(['success' => $this->product]);
            }
        }
    }

    /* Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $colors = Color::select('color_id', 'color_name')->get();
        $categories = $this->category->select('category_id', 'category_name')->get();
        $brands = brand::select('brand_id', 'brand_name')->get();
        return view('admin.products.create', compact('colors', 'categories', 'brands'));
    }

    /**
     * Show tags in tag input- create product page .
     *
     * @param $tag string
     * @return \Illuminate\Http\Response
     */
    public function productTags($tag)
    {
        $tags = \App\Models\Tag::where('tag_slug', 'like', '%' . $tag . '%')->pluck('tag_name')->toArray();
        return response()->json($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\productRequest $request
     * @return \Illuminate\Http\Response
     */

    public function store(productRequest $request)
    {
//        \Illuminate\Support\Facades\DB::enableQueryLog();
        $path = public_path(env('THUMBNAIL_PATH'));
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $input = $this->getCheckBox($request);
//        dd($input);
//        return response()->json(['success' => $input ] );

        //generate 12 digit code
        $input['sku'] = date('ymdHms');
        $product = $this->product->create($input);
        //save tags
        $this->saveTags($input,$product);
        if ($request->input('colors')){
            //save colors
            $product->colors()->attach($input['colors']);
        }
        //save categories
        $product->categories()->attach($input['categories']);
        //SAVE PHOTOS
        if ($images = $request->file('photos')) {
            $this->saveImage($images, $input, $product);
        }
        //clear cache
        Cache::forget($this->cachKey);
//        $query = \Illuminate\Support\Facades\DB::getQueryLog();
//        dd($query);
        return env('APP_AJAX')
            ? response()->json(1)
            : redirect()->route('product.index')->with(['success' => 'product has created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!ctype_digit($id)) {
            return response()->json(['error' => 'id is not valid']);
        }
        $product = $this->product->findOrFail($id);
        $comments = $product->comments()->paginate(4);
        return view('admin.products.show', compact('product', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!ctype_digit($id)) {
            return response()->json(['error' => 'id is not valid']);
        }
        $product = $this->product->findOrFail($id);
        $colors = Color::select('color_id', 'color_name')->get();
        $p_colors = $product->colors->pluck('color_id')->toArray();
        $categories = $this->category->select('category_id', 'category_name')->get();
        $p_categories = $product->categories->pluck('category_id')->toArray();
        $brands = brand::select('brand_id', 'brand_name')->get();
        return view('admin.products.edit',
            compact('product', 'colors', 'categories', 'brands', 'p_categories', 'p_colors'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(productRequest $request, $id)
    {
        if (!ctype_digit($id)) {
            return response()->json(['error' => 'id is not valid']);
        }
        //IF THIS FOLDER IS NOR DEFINED THEN CREATE IT. TO AVOID ERRORS
        $path = public_path(env('THUMBNAIL_PATH'));
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $input = $this->getCheckBox($request);
//        return response()->json(['success' => $input] );
        $product = $this->product->findOrFail($id);
        $product->fill($input);
        //Update colors
        if ($request->input('colors')){
            $product->colors()->sync($input['colors']);
        }else{
            $product->colors()->detach();
        }
        //Update categories
        $product->categories()->sync($input['categories']);
        //update tags
        $this->saveTags($input,$product);
        //SET COVER IF ITS NOT FROM NEW IMAGES
        if ($input['cover'] != null) {
            $product->cover = $input['cover'];
        }

        //IF NEW PHOTO HAS ADDED BELOW SCRIPT WILL RUN
        if ($images = $request->file('photos')) {
            $this->saveImage($images, $input, $product);
        }
        $product->save();
        Cache::forget($this->cachKey);
        return env('APP_AJAX')
            ? response()->json(1)
            : redirect()->route('product.index')->with(['success' => 'product has updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!ctype_digit($id)) {
            return response()->json(['error' => 'id is not valid']);
        }
        $product = $this->product->withTrashed()->findOrFail($id);
        if (!$product->trashed()) {
            $product->delete();
        } else {
            $product->categories()->detach();
            if ($product->colors){
                $product->colors()->detach();
            }
            $product->tags()->detach();
            // if product has photo then delete em
            if (count($product->photos) > 0) {
                $photo_ids = [];
                foreach ($product->photos as $photo) {
                    $photo_path = public_path(env("IMAGE_PATH") . $photo->addr);
                    $thumbnail_path = public_path(env("THUMBNAIL_PATH") . $photo->addr);
                    array_push($photo_ids, $photo->photo_id);
                    if (File::exists($photo_path)) {
                        unlink($photo_path);
                    }
                    if (File::exists($thumbnail_path)) {
                        unlink($thumbnail_path);
                    }
                }
                Photo::destroy($photo_ids);
            }
            $product->forceDelete();
        }

        Cache::forget($this->cachKey);
        return $product
            ? response()->json(['success' => $product])
            : response()->json(['error' => 'error']);
    }

    /**
     * save images
     * @param array $images
     * @param array $input
     * @param object $product
     */
    private function saveImage($images, $input, $product)
    {
        $all_images = [];
        foreach ($images as $key => $image) {
            $image_title = $image->getClientOriginalName();
            $image_type = $image->getClientOriginalExtension();
            $image_name = $key . ',' . date('Y_m_d_H,i,s') . '.' . $image_type;
            //create thumbnail
            Image::make($image)->resize(100, 120)->save(env('THUMBNAIL_PATH') . 'T' . $image_name);
            if ($image_title == $input['cover']) {
                $product->cover = $image_name;
                $product->save();
            }
            $image_size = $image->getClientSize();
            $image->move(env('IMAGE_PATH'), $image_name);
            array_push($all_images, [
                'photo_title' => $image_title,
                'src' => $image_name,
                'photo_size' => $image_size,
                'photo_type' => $image_type,
                'photoable_id' => $product->product_id,
                'photoable_type' => Product::class,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
        //using query builder to avoid fucking server with lots of query
        DB::table('photos')->insert($all_images);
    }

    /**
     * create tags
     * @param $input array
     * @param $product object
     */
    public function saveTags($input,$product)
    {
        //take all tags input and convert them to array and add slug for each one
        $tags_input = (explode(','  , $input['tags']));
        $tags = [];
        foreach (array_filter($tags_input) as $tag){
            array_push($tags, [
                'tag_name' => Str::lower($tag),
                'tag_slug' => Str::slug($tag)
            ]);
        }
        //check if inputed tag exists or not
        //  if not exist create new one and if exist take id of that
        $tag_obj = [];
        foreach ($tags as $tag){
            $tag_exist = Tag::where('tag_slug',$tag['tag_slug'])->first();
            if ($tag_exist){
                array_push($tag_obj,$tag_exist->tag_id);
            }else{
                array_push($tag_obj,Tag::create($tag)->tag_id);
            }
        }
        $product->tags()->sync($tag_obj);
    }

    /**
     * check checkboxes
     * @param $request
     * @return array
     */
    private function getCheckBox($request)
    {
        $input = $request->except(['_token']);
        if ($request->input('status')) {
            $input['status'] = 1;
        }else{
            $input['status'] = 0;
        }
        if ($request->input('is_off')) {
            $input['is_off'] = 1;
        }else{
            $input['is_off'] = 0;
        }
        if ($request->input('has_size')) {
            $input['has_size'] = 1;
        }else{
            $input['has_size'] = 0;
        }
        return $input;
    }
}
