<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class BrandRepository
 * @package App\Repositories
 * @version January 24, 2020, 4:34 pm +0330
*/

class BrandRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'brand_name',
        'brand_description'
    ];
    public $cacheKey = 'brands';

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
        return Brand::class;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function saveBrand($request)
    {
        $input = $this->savePhoto($request);
        $brand = $this->create($input);
        $this->forgetCache();

        return $brand;
    }

    /**
     * @param $request
     * @param $id
     * @return brand
     */
    public function updateBrand($request, $id) : brand
    {
        $input = $this->savePhoto($request);

        $brand = $this->update($input,$id);
        $this->forgetCache();
        return $brand;
    }

    /**
     * TO SAVE PHOTO IN UPDATE AND CREATE METHOD
     *
     * @param Request $request
     * @return array $input
     */
    private function savePhoto($request)
    {
        $input = $request->except('_token');
        if ($image = $request->file('brand_image')) {
            $image_type = $image->getClientOriginalExtension();
            $image_name = $input['brand_name'] . ',' . date('Y_m_d_H,i,s') . '.' . $image_type;
            $image->move(env('IMAGE_PATH'), $image_name);
            $input['brand_image'] = $image_name;
        }
        return $input;
    }

    private function forgetCache()
    {
        if (Cache::has($this->cacheKey)) {
            Cache::forget($this->cacheKey);
        }
    }
}
