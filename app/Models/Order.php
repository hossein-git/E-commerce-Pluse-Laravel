<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @package App\Models
 * @version January 24, 2020, 3:37 pm +0330
 *
 * @property GiftCard gift
 * @property \App\Models\User user
 * @property Collection products
 * @property Collection user1s
 * @property integer user_id
 * @property integer employee_id
 * @property integer gift_id
 * @property integer order_status
 * @property integer track_code
 * @property string client_name
 * @property string client_phone
 * @property string client_email
 * @property integer total_price
 * @property string details
 */
class Order extends Model
{
//    use SoftDeletes;

    public $table = 'orders';
    protected $primaryKey = 'order_id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


//    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'employee_id',
        'gift_id',
        'order_status',
        'track_code',
        'client_name',
        'client_phone',
        'client_email',
        'total_price',
        'details'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer',
        'user_id' => 'integer',
        'employee_id' => 'integer',
        'gift_id' => 'integer',
        'order_status' => 'integer',
        'track_code' => 'integer',
        'client_name' => 'string',
        'client_phone' => 'string',
        'client_email' => 'string',
        'total_price' => 'integer',
        'details' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'order_status' => 'required',
        'track_code' => 'required',
        'client_name' => 'required',
        'client_phone' => 'required',
        'client_email' => 'required',
        'total_price' => 'required'
    ];

    /**
     * @return HasMany
     */
    public function detailsOrder()
    {
        return $this->hasMany(DetailsOrder::class, 'order_id');
    }


    /**addressable
     * @return MorphOne
     */
    public function address()
    {
        return $this->morphOne(Address::class,'addressable');
    }

    /**
     * @return BelongsTo
     */
    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class,'gift_id')->select(['gift_id','gift_name','gift_amount','gift_code']);

    }

    /**
     * @return BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class,'user_id')->select(['user_id','name']);
    }

    /**
     * @return HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class,'order_id');
    }
}
