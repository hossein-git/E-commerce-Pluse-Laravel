<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

/**
 * Class Attribute_value
 * @package App\Models
 * @version January 24, 2020, 3:19 pm +0330
 *
 * @property \App\Models\Attribute attr
 * @property string value
 * @property integer attr_id
 */
class Attribute_value extends Model
{

    public $primaryKey = 'attr_value_id';
    public $table = 'attribute_values';


    public $fillable = [
        'value',
        'attr_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'attr_value_id' => 'integer',
        'value' => 'string',
        'attr_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'value' => 'required',
        'attr_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function attributes()
    {
        return $this->belongsTo(Attribute::class,'attr_id','attr_id');
    }
}
