<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Address
 * @package App\Models
 * @version January 24, 2020, 3:13 pm +0330
 *
 * @property string name
 * @property string surname
 * @property string state
 * @property string city
 * @property string area
 * @property string avenue
 * @property string street
 * @property string phone_number
 * @property integer number
 * @property string postal_code
 * @property string addressable_type
 * @property integer addressable_id
 */
class Address extends Model
{

    public $table = 'addresses';
    protected $primaryKey = 'addr_id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $fillable = [
        'name',
        'surname',
        'state',
        'city',
        'area',
        'avenue',
        'street',
        'phone_number',
        'number',
        'postal_code',
        'addressable_type',
        'addressable_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'addr_id' => 'integer',
        'name' => 'string',
        'surname' => 'string',
        'state' => 'string',
        'city' => 'string',
        'area' => 'string',
        'avenue' => 'string',
        'street' => 'string',
        'phone_number' => 'string',
        'number' => 'integer',
        'postal_code' => 'string',
        'addressable_type' => 'string',
        'addressable_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'surname' => 'required',
        'state' => 'required',
        'city' => 'required',
        'phone_number' => 'required',
        'number' => 'required',
        'postal_code' => 'required',
        'addressable_type' => 'required',
        'addressable_id' => 'required'
    ];

    /**
     * Get the owning addressable model.
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    
}
