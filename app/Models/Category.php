<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Class Category
 * @package App\Models
 * @version January 24, 2020, 3:21 pm +0330
 *
 * @property \Illuminate\Database\Eloquent\Collection products
 * @property string category_name
 * @property string category_slug
 * @property integer _lft
 * @property integer _rgt
 * @property integer parent_id
 */
class Category extends Model
{
    use NodeTrait;

    public $table = 'categories';
    protected $primaryKey = 'category_id';


    public $fillable = [
        'category_name',
        'category_slug',
        '_lft',
        '_rgt',
        'parent_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_id' => 'integer',
        'category_name' => 'string',
        'category_slug' => 'string',
        '_lft' => 'integer',
        '_rgt' => 'integer',
        'parent_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'category_name' => 'required|string',
        'category_slug' => 'required|string|unique:categories,category_slug',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }

    /**
     * Relation to children.
     *
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(get_class($this), $this->getParentIdName())
            ->setModel($this)->with('children')->select(['category_id', 'category_slug', 'category_name']);
    }
}