<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Repositories\BaseRepository;

/**
 * Class AttributeRepository
 * @package App\Repositories
 * @version January 24, 2020, 4:34 pm +0330
*/

class AttributeRepository extends BaseRepository
{
    public $viewPrefix = 'admin.attributes.';
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'attr_name',
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
        return Attribute::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateAttribute($request)
    {
        $attribute = Attribute::findOrFail($request->input('attr_id'));

        $attribute->fill(['attr_name' => $request->input('attr_name')]);

        if ($request->ajax()) {
            foreach (array_filter($request->input('value')) as $key => $value) {

                $attribute->attributeValues()->updateOrCreate([
                    'attr_value_id' => $key], ['value' => $value]);

            }
        }
        else {
            foreach ($request->input('value') as $key => $value) {
                if (is_string($value)) {
                    $value = explode(" ", $value);
                }
                foreach ($value as $key => $item) {
                    $attribute->attributeValues()->updateOrCreate([
                        'attr_value_id' => $key], ['value' => $item]);
                }
            }
        }

        return $attribute->save();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveAttribute($request)
    {
        $values = [];

        //with array_filter null values will deleted
        foreach (array_filter($request->input('value')) as $value) {
            array_push($values, [
                'value' => $value
            ]);
        }
        $product = $this->product->findOrFail($request->input('product_id'), 'product_id');

//        $attribute = Attribute::create(['attr_name' => $request->input('attr_name')]);
        $attribute = $product->attributes()->create(['attr_name' => $request->input('attr_name')]);

        return $attribute->attributeValues()->createMany($values);
//        $product->attributeValues()->attach($id_values);
    }
}
