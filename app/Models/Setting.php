<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'setting_id';
    protected $fillable = [
        'site_title', 'site_description', 'site_logo', 'site_address'
        , 'site_phone', 'site_email', 'site_fax'
    ];
    protected $guarded = ['setting_id'];
    public $timestamps = false;

    // take asset of the owned image
    public function getSrcAttribute()
    {
        return asset(env('IMAGE_PATH') . $this->attributes['site_logo']);
    }


}
