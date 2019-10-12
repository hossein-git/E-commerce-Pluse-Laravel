<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $primaryKey = 'color_id';
    protected $fillable = ['color_id','color_name','color_code'];
//    protected $guarded =['color_id'];
    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(Product::class,'color_product','color_id','product_id');
    }
}
