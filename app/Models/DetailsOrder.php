<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailsOrder extends Model
{
    protected $primaryKey = 'details_order_id';
    protected $fillable = ['order_id', 'product_id', 'product_attr_id', 'product_sku', 'product_price',
        'discount', 'quantity', 'size', 'color', 'total_price'];
    protected $guarded = ['details_order_id'];


    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function products()
    {
        return $this->hasOne(Product::class,'product_id','product_id')->first();
    }



}
