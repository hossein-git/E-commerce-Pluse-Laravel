<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class CategoryRepository
 * @package App\Repositories
 * @version January 24, 2020, 3:21 pm +0330
 */
class CategoryRepository extends BaseRepository
{


    public $cacheKey = 'categories';
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_name',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
    }

    /**
     * @param $request
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function saveCategory($request)
    {
        $input = $request->except('_token');
        if ($input['parent_id'] != null) {
            $category = $this->find($input['parent_id']);
            $category = $category->parent()->create($input);
        } else {
            $category = $this->create($input);
        }
        $this->clearCache();

        return $category;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function destroy($id)
    {
        $category = $this->find($id);
        $category->products()->detach();
        $category = $category->delete();
        $this->clearCache();
        return $category;
    }


    private function clearCache()
    {
        if (Cache::has($this->cacheKey)) {
            Cache::forget($this->cacheKey);
        }
    }

}
