<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * @package App\Models
 * @version January 24, 2020, 3:37 pm +0330
 *
 * @property \App\Models\Order order
 * @property \App\Models\User user
 * @property integer user_id
 * @property integer order_id
 * @property boolean status
 * @property string payment_status
 * @property string sub_total
 */
class Payment extends Model
{

    protected $primaryKey = 'payment_id';
    public $table = 'payments';

    public $fillable = [
        'user_id',
        'order_id',
        'status',
        'payment_status',
        'sub_total'
    ];

    const UPDATED_AT = null;
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'payment_id' => 'integer',
        'user_id' => 'integer',
        'order_id' => 'integer',
        'status' => 'boolean',
        'payment_status' => 'string',
        'sub_total' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'order_id' => 'required',
        'status' => 'required',
        'payment_status' => 'required',
        'sub_total' => 'required'
    ];

    /**
     * take orders of this payment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * take users of this payment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
