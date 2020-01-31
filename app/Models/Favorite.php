<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Favorite
 * @package App\Models
 * @version January 24, 2020, 3:36 pm +0330
 *
 * @property \App\Models\Product product
 * @property \App\Models\User user
 * @property integer user_id
 * @property integer product_id
 */
class Favorite extends Model
{
    protected $primaryKey = 'favorite_id';
    protected $fillable = ['product_id','user_id'];
    public $timestamps = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'favorite_id' => 'integer',
        'user_id' => 'integer',
        'product_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'product_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
   /* public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }*/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
   /* public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }*/
}
