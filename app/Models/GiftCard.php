<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class GiftCard
 * @package App\Models
 * @version January 24, 2020, 3:36 pm +0330
 *
 * @property Collection users
 * @property Collection user1s
 * @property string gift_name
 * @property integer gift_amount
 * @property string gift_code
 * @property boolean status
 */
class GiftCard extends Model
{


    public $table = 'gift_cards';
    protected $primaryKey = 'gift_id';

    public $fillable = [
        'gift_name',
        'gift_amount',
        'gift_code',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'gift_id' => 'integer',
        'gift_name' => 'string',
        'gift_amount' => 'integer',
        'gift_code' => 'string',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'gift_name' => 'required|unique:gift_cards',
        'gift_code' => ['required', 'unique:gift_cards', 'min:6'],
        'gift_amount' => 'required',
    ];

    /**
     * @return HasMany
     */
    public function order()
    {
        return $this->hasMany(Order::class,'gift_id','gift_id');
    }

    /**
     * @return HasMany
     */
    public function checkGift()
    {
        return $this->hasMany(CheckGift::class,'gift_id');
    }
}
