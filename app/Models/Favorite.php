<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $primaryKey = 'favorite_id';
    protected $fillable = ['product_id','id'];
    protected $guarded = 'favorite_id';
    public $timestamps = false;
}
