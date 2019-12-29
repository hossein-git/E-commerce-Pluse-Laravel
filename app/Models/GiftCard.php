<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    protected $primaryKey = 'gift_id';
    protected $fillable = ['gift_name','gift_code','status','gift_amount'];
    protected $guarded = ['gift_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany(Order::class,'gift_id','gift_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checkGift()
    {
        return $this->hasMany(CheckGift::class,'gift_id');
    }

}
