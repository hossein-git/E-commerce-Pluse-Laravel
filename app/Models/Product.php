<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravelista\Comments\Commentable;
use willvincent\Rateable\Rateable;

/**
 * Class Product
 * @package App\Models
 * @version January 24, 2020, 3:37 pm +0330
 *
 * @property \App\Models\Brand brand
 * @property \Illuminate\Database\Eloquent\Collection attributes
 * @property \Illuminate\Database\Eloquent\Collection categories
 * @property \Illuminate\Database\Eloquent\Collection colors
 * @property \Illuminate\Database\Eloquent\Collection orders
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection tags
 * @property integer product_id
 * @property integer brand_id
 * @property string product_name
 * @property string product_slug
 * @property string sku
 * @property boolean status
 * @property string data_available
 * @property boolean is_off
 * @property integer off_price
 * @property boolean has_size
 * @property integer buy_price
 * @property integer sale_price
 * @property integer price
 * @property integer quantity
 * @property string made_in
 * @property number weight
 * @property string description
 * @property string cover
 */
class Product extends Model
{
    use SoftDeletes, Commentable, Rateable;

    public $table = 'products';

    protected $primaryKey = 'product_id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'brand_id',
        'product_name',
        'product_slug',
        'sku',
        'status',
        'data_available',
        'is_off',
        'off_price',
        'has_size',
        'buy_price',
        'sale_price',
        'quantity',
        'made_in',
        'weight',
        'description',
        'cover'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'product_id' => 'integer',
        'brand_id' => 'integer',
        'product_name' => 'string',
        'product_slug' => 'string',
        'sku' => 'string',
        'status' => 'boolean',
        'data_available' => 'date',
        'is_off' => 'boolean',
        'off_price' => 'integer',
        'has_size' => 'boolean',
        'buy_price' => 'integer',
        'sale_price' => 'integer',
        'quantity' => 'integer',
        'made_in' => 'string',
        'weight' => 'float',
        'description' => 'string',
        'cover' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'brand_id' => 'required',
        'product_name' => 'required',
        'product_slug' => 'required',
        'sku' => 'required',
        'status' => 'required',
        'is_off' => 'required',
        'off_price' => 'required',
        'has_size' => 'required',
        'buy_price' => 'required',
        'sale_price' => 'required',
        'quantity' => 'required',
        'description' => 'required',
        'cover' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function brands()
    {
        return $this->belongsTo(brand::class, 'brand_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_product', 'product_id', 'color_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function photos()
    {
        return $this->morphMany(Photo::class, 'products', 'photoable_type', 'photoable_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class,'product_id', 'product_id')->with('attributeValues');
    }

    /**
     * @return boolean
     */
    public function favorited()
    {
        return (bool) Favorite::where('user_id', auth()->id())
            ->where('product_id', $this->product_id)
            ->first();
    }


    /**
     * get created at in diffForHumans forma
     * @return string
     * @throws \Exception
     */
    public function getCreatedAtAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    /**
     * save slug in true form
     * @param $value
     * @return string
     */
    public function setProductSlugAttribute($value)
    {
        return $this->attributes['product_slug'] = Str::slug($value);
    }

    /**get cover path
     * @return string
     */
    public function getCoverAttribute()
    {
        return asset(env('IMAGE_PATH') . $this->attributes['cover']);
    }

    /**get THUMBNAIL path
     * @return string
     */
    public function getThumbnailAttribute()
    {
        return asset(env('THUMBNAIL_PATH') . "T" . $this->attributes['cover']);
    }

    /**
     * GET PRICE AFTER DISCOUNT
     * @return string
     */
    public function getPriceAttribute()
    {
        if ($this->attributes['off_price'] == null) {
            $this->attributes['off_price'] = 0;
        }
        return number_format($this->attributes['sale_price'] - $this->attributes['off_price']);
    }

    /**
     * GET PERCENTAGE OF OFF PRICE
     * @return bool|string
     */
    public function getOffAttribute()
    {
        $off = ($this->attributes['sale_price'] - ($this->attributes['sale_price'] - $this->attributes['off_price'])) / $this->attributes['sale_price'] * 100;
        return substr($off, 0, 3);
    }


    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'product_index';
    }


    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        return array('product_name' => $array['product_name'], 'product_slug' => $array['product_slug']);
    }
}
