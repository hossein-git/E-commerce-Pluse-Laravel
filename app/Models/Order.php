<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id', 'employee_id', 'gift_id', 'order_status','client_phone','client_email',
        'track_code', 'client_name', 'total_price', 'details','user_id'
    ];

    protected $guarded = ['order_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detailsOrder()
    {
        return $this->hasMany(DetailsOrder::class, 'order_id');
    }


    /**addressable
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function address()
    {
        return $this->morphOne(Address::class,'addressable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class,'gift_id')->select(['gift_id','gift_name','gift_amount','gift_code']);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class,'user_id')->select(['user_id','name']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class,'order_id');
    }

}
