<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * @package App\Models
 * @version January 24, 2020, 3:41 pm +0330
 *
 * @property string site_title
 * @property string site_description
 * @property string site_logo
 * @property string site_icon
 * @property string site_address
 * @property string site_phone
 * @property string site_email
 * @property string site_fax
 * @property string src
 * @property string icon
 */
class Setting extends Model
{


    public $table = 'settings';
    protected $primaryKey = 'setting_id';

    public $timestamps = false;

    public $fillable = [
        'site_title',
        'site_description',
        'site_logo',
        'site_icon',
        'site_address',
        'site_phone',
        'site_email',
        'site_fax'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'setting_id' => 'integer',
        'site_title' => 'string',
        'site_description' => 'string',
        'site_logo' => 'string',
        'site_icon' => 'string',
        'site_address' => 'string',
        'site_phone' => 'string',
        'site_email' => 'string',
        'site_fax' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'site_title' => 'required',
        'site_description' => 'required',
        'site_logo' => 'required',
        'site_icon' => 'required',
        'site_address' => 'required',
        'site_phone' => 'required',
        'site_email' => 'required',
        'site_fax' => 'required'
    ];

    /**
     * take asset of the logo
     * @return string
     */
    public function getSrcAttribute()
    {
        return asset(env('IMAGE_PATH') . $this->attributes['site_logo']);
    }


    /**
     * get site icon with public path
     * @return string
     */
    public function getIconAttribute()
    {
        return asset(env('IMAGE_PATH') . $this->attributes['site_icon']);
    }
    
}
