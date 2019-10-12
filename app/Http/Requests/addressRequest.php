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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
              'name'    => ['string', '']
            , 'surname' => ['string', '']
            , 'state' =>   ['string', '']
            , 'city' =>    ['string', '']
            , 'area' =>    ['string', '']
            , 'avenue' =>  ['string', '']
            , 'street' =>  ['string', '']
            , 'phone_number' => []
            , 'postal_code' => []
            , 'number' => ['numeric','max:5']
            , 'addressable_id' => ['numeric']
            , 'addressable_type' => ['string']
        ];
    }
}
