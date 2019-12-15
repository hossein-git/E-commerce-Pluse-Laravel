<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'role_id';
    protected $fillable = ['name','description'];

    public function user()
    {
        return $this->hasMany(User::class,'role_id');
    }

}
