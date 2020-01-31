<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Tag
 * @package App\Models
 * @version January 24, 2020, 3:41 pm +0330
 *
 * @property Collection products
 * @property string tag_slug
 * @property string tag_name
 */
class Tag extends Model
{


    public $table = 'tags';
    protected $primaryKey = 'tag_id';

    public $fillable = [
        'tag_slug',
        'tag_name'
    ];

    public $timestamps  = false;
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tag_id' => 'integer',
        'tag_slug' => 'string',
        'tag_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tag_slug' => 'required',
        'tag_name' => 'required'
    ];

    /**
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tags', 'tag_id', 'product_id');
    }
}
