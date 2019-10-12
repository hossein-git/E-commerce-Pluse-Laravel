<?php

namespace App\Http\Controllers\ADmin;

use App\Http\Requests\productRequest;
use App\Models\brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class productController extends Controller
{
    private $product;
    private $category;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    //take trash products
    public function withTrash()
    {
        $products = $this->product::onlyTrashed()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    //Route : $this->product/sort/{sort?} route name: $product.index.sort
    public function sort($sort = 'product_id')
    {
        $products = $this->product::orderBy("$sort")->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    //Route : $this->product/sort/sort/{category_id} route name:$product.index.sortCat
    public function sortByCategory($category_id)
    {
        if (ctype_digit($category_id)) {
            $category = $this->category->findOrFail($category_id);
            $products = $category->products()->paginate(10);
            return view('admin.products.index', compact('products'));
        }
    }

    //Route : $this->product/index/restore name:$this->product.restore
    public function restore($id)
    {
       if (ctype_digit($id)){
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(productRequest $request)
    {
        $path = public_path(env('THUMBNAIL_PATH'));
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $input = $request->except('_token');
//        dd($input);
//        return response()->json(['success' => $input ] );

        if ($request->status == 'on') {
            $input['status'] = 1;
        } else {
            $input['status'] = 0;
        }
        if ($request->is_off == 'on') {
            $input['is_off'] = 1;
        } else {
            $input['is_off'] = 0;
        }
        //generate 12 digit code
        $input['sku'] = date('ymdHms');
        $product = $this->product->create($input);
        //save colors
        $colors = Color::findOrFail($input['colors']);
        $product->colors()->saveMany($colors);
        //save categories
        $categories = $this->category->findOrFail($input['categories']);
        $product->categories()->saveMany($categories);
        //SAVE PHOTOS
        if ($images = $request->file('photos')) {
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

        if (env('APP_AJAX') == true) {
            return response()->json(1);
        }
        return redirect()->route('product.index')->with(['success' => 'product has created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->product->findOrFail($id);
        $comments = $product->comments()->paginate(4);
        return view('admin.products.show',compact('product','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->product->findOrFail($id);
        $p_categories = $product->categories->pluck('category_id')->toArray();
        $colors = Color::select('color_id', 'color_name')->get();
        $p_colors = $product->colors->pluck('color_id')->toArray();
        $categories = $this->category->select('category_id', 'category_name')->get();
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
        $path = public_path(env('THUMBNAIL_PATH'));
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $input = $request->except('_token');
//        dd($input);
//        return response()->json(['success' => $input] );
        if ($request->status == 'on') {
            $input['status'] = 1;
        } else {
            $input['status'] = 0;
        }
        if ($request->is_off == 'on') {
            $input['is_off'] = 1;
        } else {
            $input['is_off'] = 0;
        }

        $product = $this->product->findOrFail($id);
        $product->fill($input);
        //Update colors
        $colors = Color::findOrFail($input['colors']);
        $product->colors()->sync($colors);
        //Update categories
        $categories = $this->category->findOrFail($input['categories']);
        $product->categories()->sync($categories);
        //SET COVER IF ITS NOT FROM NEW IMAGES
        if ($input['cover'] != null) {
            $product->cover = $input['cover'];
        }

        //IF NEW PHOTO HAS ADDED BELOW SCRIPT WILL RUN
        if ($images = $request->file('photos')) {
            $all_images = [];
            foreach ($images as $key => $image) {
                $image_title = $image->getClientOriginalName();
                $image_type = $image->getClientOriginalExtension();
                $image_name = $key . ',' . date('Y_m_d_H,i,s') . '.' . $image_type;
                if ($image_title == $input['cover']) {
                    $product->cover = $image_name;
                }
                //IF IMAGE HAS ALREADY UPDATED,THIS SCRIPT WILL BE AVOIDED
                //create thumbnail
                Image::make($image)->resize(267, 341)->save(env('THUMBNAIL_PATH') . 'T' . $image_name);
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
        $product->save();
        if (env('APP_AJAX') == true) {
            return response()->json(1);
        }
        return redirect()->route('product.index')->with(['success' => 'product has updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->product->withTrashed()->findOrFail($id);
        if ($product->trashed() == false){
            $product->delete();
        }else{
            $product->categories()->detach();
            $product->colors()->detach();
            // if product has photo then delete em
            if (count($product->photos) > 0) {
                $photo_ids = [];
                foreach ($product->photos as $photo) {
                    $photo_path = public_path(env("IMAGE_PATH") . $photo->addr);
                    $thumbnail_path = public_path(env("THUMBNAIL_PATH") . $photo->addr);
                    array_push($photo_ids,$photo->photo_id);
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
        if ($product) {
            return response()->json(['success' => $product]);
        }
        return response()->json(['error' => 'error']);
    }
}
