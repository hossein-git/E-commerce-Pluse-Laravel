<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addressRequest extends FormRequest
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
            'name' => ['required', 'string', 'regex:/^([a-zA-Z\' ]+)$/']
            , 'surname' => ['required', 'string', 'regex:/^([a-zA-Z\' ]+)$/']
            , 'state' => ['required', 'string', 'regex:/^([a-zA-Z\' ]+)$/']
            , 'city' => ['required', 'string', 'regex:/^([a-zA-Z\' ]+)$/']
            , 'area' => ['string', 'nullable'  , 'regex:/^([a-zA-Z\' ]+)$/']
            , 'avenue' => ['string', 'nullable' , 'regex:/^([a-zA-Z\' ]+)$/']
            , 'street' => ['string', 'nullable' , 'regex:/^([a-zA-Z\' ]+)$/']
            , 'phone_number' => ['required' , 'string']
            , 'postal_code' => ['required', 'numeric' , 'regex:^[0-9]^']
            , 'number' => ['required', 'numeric']

        ];
    }
}
