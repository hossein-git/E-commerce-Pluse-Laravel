<?php

namespace App\Http\Requests\Addresses;

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
            'name' => ['required', 'string', 'regex:/^([a-zA-Z\' ]+)$/', 'max:15']
            , 'surname' => ['required', 'string', 'regex:/^([a-zA-Z\' ]+)$/', 'max:20']
            , 'state' => ['required', 'string', 'regex:/^([a-zA-Z\' ]+)$/', 'max:20']
            , 'city' => ['required', 'string', 'regex:/^([a-zA-Z\' ]+)$/', 'max:20']
            , 'area' => ['string', 'nullable', 'regex:/^([a-zA-Z\' ]+)$/', 'max:20']
            , 'avenue' => ['string', 'nullable', 'regex:/^([a-zA-Z\' ]+)$/', 'max:20']
            , 'street' => ['string', 'nullable', 'regex:/^([a-zA-Z\' ]+)$/']
            , 'phone_number' => ['required', 'string']
            , 'postal_code' => ['required', 'numeric', 'regex:^[0-9]^']
            , 'number' => ['required', 'numeric']

        ];
    }
}
