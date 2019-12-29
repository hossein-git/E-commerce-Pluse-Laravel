<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckGift extends Model
{
    //NO NEED TO UPDATED_AT
    const UPDATED_AT = null;

    protected $primaryKey = 'check_gift_id';
    protected $table = 'check_gift';
    protected $fillable = ['user_id' , 'gift_id'];
    protected $guarded = ['check_gift_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class,'gift_id');
    }


}
