<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $primaryKey = 'addr_id';
    protected $fillable = ['name', 'surname', 'state', 'city', 'area', 'avenue',
        'street', 'phone_number', 'postal_code', 'number', 'addressable_id', 'addressable_type'];
    protected $guarded = ['addr_id'];

    public function order()
    {
        return $this->morphTo(Order::class);
    }
}
