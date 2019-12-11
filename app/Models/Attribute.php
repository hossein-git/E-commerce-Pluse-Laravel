<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public $primaryKey = 'attr_id';
    public $fillable = ['attr_name','product_id'];
    protected $guarded = ['attr_id'];

    public function attributeValues()
    {
        return $this->hasMany(Attribute_Value::class,'attr_id','attr_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id','product_id');
    }

}
