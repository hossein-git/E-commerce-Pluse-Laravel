<?php

namespace App\Http\Requests\Brands;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'brand_name' => 'required|string',
            'brand_slug' => ['required','string',
                'unique:brands,brand_slug,NULL,id,brand_id,:'. $this->brand
            ],
            'brand_image' => 'required|mimes:jpeg,png|max:1000',
            'brand_description' => 'required|string',
        ];
    }
}
