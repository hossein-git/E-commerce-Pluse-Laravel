<?php

namespace App\Repositories;


use App\Models\Photo;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**]
 * Class ProductRepository
 * @package App\Repositories
 * @version January 24, 2020, 3:37 pm +0330
 */
class ProductRepository extends BaseRepository
{
    /**
     * @var string
     */
    public $viewPrefix = 'admin.products.';

    /**
     * @var string
     */
    private $cacheKey = 'products';

    /**
     * @var string
     */
    public $paginateNum = 10;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'product_name',
        'product_slug',
        'sku',
        'status',
        'made_in',
        'description',
    ];


    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Product::class;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findWithTrash($id)
    {
        $this->checkId($id);
        return $this->model->withTrashed()->findOrFail($id);
    }

    /**
     * step 1
     * @param $request
     * @return Product
     */
    public function createProduct($request): Product
    {
        $input = $this->getCheckBox( $request);

//        dd($input);
//        return response()->json(['success' => $input ] );
        //generate 12 digit code
        $input['sku'] = date('ymdHms');
        if ($image = $request->file('cover')) {
            $input = $this->saveCover($image,$input);
        }
        $product = $this->model->create($input);
        //clear cache
        if (Cache::has($this->cacheKey)) {
            Cache::forget($this->cacheKey);
        }

        return $product;
    }

    /**
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function createProductSecondStep($request)
    {
        $input = $request->except('_token');
        $product = session()->get('create-product');
        //save tags
        try {
            $this->saveTags($input, $product);
        } catch (\Exception $exception) {
            throw new \Exception();
        }
        //save colors
        if ($request->input('colors')) {
            $product->colors()->attach($input['colors']);
        }
        //save categories
        $product->categories()->attach($input['categories']);
        //SAVE PHOTOS

        if ($images = $request->file('photos')) {
            try {
                $this->saveImage($images, $input, $product);
            } catch (\Exception $exception) {
                throw new \Exception();
            }
        }

        return $product;

    }

    /**
     * @param $request
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function updateProduct($request, int $id): bool
    {
        $this->checkId($id);
        //IF THIS FOLDER IS NOR DEFINED THEN CREATE IT. TO AVOID ERRORS
        $path = public_path(env('THUMBNAIL_PATH'));
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $input = $this->getCheckBox($request);
//        return response()->json(['success' => $input] );

        $product = $this->find($id);
        $product->fill($input);

        //Update colors
        if ($request->input('colors')) {
            $product->colors()->sync($input['colors']);
        } else {
            $product->colors()->detach();
        }

        //Update categories
        $product->categories()->sync($input['categories']);

        //update tags
        try {
            $this->saveTags($input, $product);
        } catch (\Exception $exception) {
            throw new \Exception();
        }


        //SET COVER IF ITS NOT FROM NEW IMAGES
        if ($input['cover'] != null) {
            $product->cover = $input['cover'];
        }


        //IF NEW PHOTO HAS ADDED BELOW SCRIPT WILL RUN
        if ($images = $request->file('photos')) {
            try {
                $this->saveImage($images, $input, $product);
            } catch (\Exception $exception) {
                throw new \Exception();
            }
        }
        $this->forgetCache();

        return $product->save();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $this->checkId($id);
        $product = $this->model->withTrashed()->findOrFail($id);
        if (!$product->trashed()) {
            $product = $product->delete();
        } else {
            $product->categories()->detach();
            if ($product->colors) {
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
            $product = $product->forceDelete();
        }
        Cache::forget($this->cacheKey);
        return $product;

    }

    /**
     * check checkboxes
     * @param $request
     * @return array
     */
    private function getCheckBox($request): array
    {
        $input = $request->except(['_token']);
        if ($request->input('status')) {
            $input['status'] = 1;
        } else {
            $input['status'] = 0;
        }
        if ($request->input('is_off')) {
            $input['is_off'] = 1;
        } else {
            $input['is_off'] = 0;
        }
        if ($request->input('has_size')) {
            $input['has_size'] = 1;
        } else {
            $input['has_size'] = 0;
        }
        return $input;
    }

    /**
     * create tags
     * @param $input array
     * @param $product object
     */
    public function saveTags($input, $product)
    {
        //take all tags input and convert them to array and add slug for each one
        $tags_input = (explode(',', $input['tags']));
        $tags = [];
        foreach (array_filter($tags_input) as $tag) {
            array_push($tags, [
                'tag_name' => $tagName = Str::lower($tag),
                'tag_slug' => Str::slug($tagName)
            ]);
        }
        //check if inputed tag exists or not
        //  if not exist create new one and if exist take id of that
        $tag_obj = [];
        foreach ($tags as $tag) {
            $tag_exist = Tag::where('tag_slug', $tag['tag_slug'])->first();
            if ($tag_exist) {
                array_push($tag_obj, $tag_exist->tag_id);
            } else {
                array_push($tag_obj, Tag::create($tag)->tag_id);
            }
        }
        $product->tags()->sync($tag_obj);
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

            if (in_array('cover',$input) && $image_title == $input['cover']) {
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

        if (!DB::table('photos')->insert($all_images)) {
            Log::channel('crud')->error('image insert to data base failed' . "product id : {$product->product_id}");
        }

    }

    /**
     * @param $image
     * @param $input
     * @return string
     */
    private function saveCover($image, $input)
    {
        $path = public_path(env('THUMBNAIL_PATH', 'thumbnails\\'));
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $image_type = $image->getClientOriginalExtension();
        $image_name = $input['product_slug'] . '.' . $image_type;
        $image->move(env('IMAGE_PATH'), $image_name);

        $input['cover'] = $image_name;

        return $input;
    }

    private function forgetCache()
    {
        if (Cache::has($this->cacheKey)) {
            Cache::forget($this->cacheKey);
        }
    }


}
