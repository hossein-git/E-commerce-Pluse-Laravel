<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Color
 * @package App\Models
 * @version January 24, 2020, 3:30 pm +0330
 *
 * @property \Illuminate\Database\Eloquent\Collection products
 * @property string color_name
 * @property string color_code
 */
class Color extends Model
{

    public $table = 'colors';
    protected $primaryKey = 'color_id';
    public $timestamps = false;

    public $fillable = [
        'color_name',
        'color_code'
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'color_id' => 'integer',
        'color_name' => 'string',
        'color_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'color_name' => 'required',
        'color_code' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class,'color_product','color_id','product_id');
    }
}
