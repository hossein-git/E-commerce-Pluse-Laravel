<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class DetailsOrder
 * @package App\Models
 * @version January 24, 2020, 3:36 pm +0330
 *
 * @property \App\Models\Order order
 * @property \App\Models\Product product
 * @property integer order_id
 * @property integer product_id
 * @property string attributes
 * @property string product_slug
 * @property integer product_price
 * @property integer quantity
 * @property string size
 * @property string color
 */
class DetailsOrder extends Model
{
    protected $primaryKey = 'details_order_id';
    public $table = 'details_orders';

    public $fillable = [
        'order_id',
        'product_id',
        'attributes',
        'product_slug',
        'product_price',
        'quantity',
        'size',
        'color',
        'total_price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'details_order_id' => 'integer',
        'order_id' => 'integer',
        'product_id' => 'integer',
        'attributes' => 'string',
        'product_slug' => 'string',
        'product_price' => 'integer',
        'quantity' => 'integer',
        'size' => 'string',
        'color' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'order_id' => 'required',
        'product_id' => 'required',
        'product_slug' => 'required',
        'product_price' => 'required',
        'quantity' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
