<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute_Value extends Model
{
    public $primaryKey = 'attr_value_id';
    protected $fillable = ['value', 'attr_id'];
    protected $guarded = ['attr_value_id'];
    protected $table = 'attribute_values';

    public function attributes()
    {
        return $this->belongsTo(Attribute::class,'attr_id','attr_id');
    }


}
