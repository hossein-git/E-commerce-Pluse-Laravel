<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package App\Models
 * @version January 24, 2020, 3:41 pm +0330
 *
 * @property string name
 * @property string description
 * @property string guard_name
 */
class Role extends Model
{


    public $table = 'roles';
    protected $primaryKey = 'id';


    public $fillable = [
        'name',
        'description',
        'guard_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'guard_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'required',
        'guard_name' => 'required'
    ];

    public function user()
    {
        return $this->hasMany(User::class,'role_id');
    }
}
