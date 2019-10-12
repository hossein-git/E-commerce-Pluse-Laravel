<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;


class Category extends Model
{
    use NodeTrait;

    protected $primaryKey = 'category_id';
    protected $fillable = ['category_name', 'category_slug' , 'parent_id'];
//    protected $guarded = ['category_id'];


    public function products()
    {
        return $this->belongsToMany(Product::class,'category_product','category_id','product_id');
    }

//    public function children() {
//        return $this->hasMany(Category::class,'parent_id','category_id') ;
//    }

}
