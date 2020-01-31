<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

/**
 * Class Attribute
 * @package App\Models
 * @version January 24, 2020, 3:18 pm +0330
 *
 * @property \App\Models\Product product
 * @property \Illuminate\Database\Eloquent\Collection attributeValues
 * @property string attr_name
 * @property integer product_id
 */
class Attribute extends Model
{

    public $primaryKey = 'attr_id';
    public $table = 'attributes';


    public $fillable = [
        'attr_name',
        'product_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'attr_id' => 'integer',
        'attr_name' => 'string',
        'product_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'attr_name' => 'required',
        'product_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeValues()
    {
        return $this->hasMany(Attribute_Value::class,'attr_id','attr_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products()
    {
        return $this->belongsTo(Product::class,'product_id','product_id');
    }
}
