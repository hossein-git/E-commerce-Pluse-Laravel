<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Photo
 * @package App\Models
 * @version January 24, 2020, 3:37 pm +0330
 *
 * @property string photo_title
 * @property string src
 * @property string addr
 * @property string thumbnail
 * @property integer photo_size
 * @property string photo_type
 * @property string photoable_type
 * @property integer photoable_id
 */
class Photo extends Model
{

    public $table = 'photos';
    protected $primaryKey = 'photo_id';

    public $fillable = [
        'photo_title',
        'src',
        'photo_size',
        'photo_type',
        'photoable_type',
        'photoable_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'photo_id' => 'integer',
        'photo_title' => 'string',
        'src' => 'string',
        'photo_size' => 'integer',
        'photo_type' => 'string',
        'photoable_type' => 'string',
        'photoable_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'photo_title' => 'required',
        'src' => 'required',
        'photo_size' => 'required',
        'photo_type' => 'required',
        'photoable_type' => 'required',
        'photoable_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function products()
    {
        return $this->morphTo(Product::class, 'photoable_type', 'photoable_id');
    }

    /**
     * Display a complete addr of image for browser .
     *
     * @return \Illuminate\Http\Response
     */
    public function getSrcAttribute()
    {
        return asset(env("IMAGE_PATH") . $this->attributes['src']);

    }

    /**
     * Display just the src .
     *
     * @return \Illuminate\Http\Response
     */
    public function getAddrAttribute()
    {
        return $this->attributes['src'];

    }

    /**
     * Display a complete THUMBNAIL src of image .
     *
     * @return \Illuminate\Http\Response
     */
    public function getThumbnailAttribute()
    {
        return asset(env("THUMBNAIL_PATH") . 'T' . $this->attributes['src']);
    }


}
