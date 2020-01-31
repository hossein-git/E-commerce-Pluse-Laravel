<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class productRequest extends FormRequest
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
            'brand_id' => 'required|numeric',
            'product_name' => 'required|string',
            'product_slug' => ['required','string',
                Rule::unique('products','product_slug')->whereNot('product_id',$this->product)
            ]  ,
            'buy_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'made_in' => 'required|string',
            'description' => 'required|string',
            'cover' => 'mimes:jpeg,png,jpg|max:20000'
        ];
    }
}
