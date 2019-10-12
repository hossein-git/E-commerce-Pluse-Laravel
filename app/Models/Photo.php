<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $primaryKey = 'photo_id';
    protected $fillable = [
        'photo_title', 'src', 'thumbnail', 'photo_size', 'photo_type', 'photoable_id', 'photoable_type'
    ];
    protected $guarded = ['photo_id'];

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
