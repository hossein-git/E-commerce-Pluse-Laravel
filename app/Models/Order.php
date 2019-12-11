<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id', 'employee_id', 'gift_id', 'order_status','client_phone',
        'track_code', 'client_name', 'total_price', 'details','user_id'
    ];

    protected $guarded = ['order_id'];

    public function detailsOrder()
    {
        return $this->hasMany(DetailsOrder::class, 'order_id');
    }

    public function address()
    {
        return $this->morphMany(Address::class,'order','addressable_type','addressable_id');
    }

    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class,'gift_id')->select(['gift_id','gift_name','gift_amount','gift_code']);

    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id')->select(['user_id','name']);
    }

}
