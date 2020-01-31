<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

/**
 * Class CheckGift
 * @package App\Models
 * @version January 24, 2020, 3:22 pm +0330
 *
 * @property \App\Models\GiftCard gift
 * @property \App\Models\User user
 * @property integer user_id
 * @property integer gift_id
 */
class CheckGift extends Model
{

    const UPDATED_AT = null;

    public $table = 'check_gift';
    protected $primaryKey = 'check_gift_id';

    public $fillable = [
        'user_id',
        'gift_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'check_gift_id' => 'integer',
        'user_id' => 'integer',
        'gift_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'gift_id' => 'required',
        'created_at' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class,'gift_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
   /* public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }*/
}
