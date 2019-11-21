<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'product_slug' => 'required|string|unique:products',
            'buy_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'made_in' => 'required|string',
            'description' => 'required|string',
            'colors' => 'required',
            'tags' => 'required',
            'categories' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg',
            'cover' => 'required|string'
        ];
    }
}
