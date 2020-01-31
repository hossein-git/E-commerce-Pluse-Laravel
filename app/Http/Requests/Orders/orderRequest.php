<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class orderRequest extends FormRequest
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
              'user_id' => ['nullable', 'numeric']
            , 'employee_id' => ['nullable', 'numeric']
            , 'gift_id'     => ['nullable', 'numeric']
            , 'order_status'=> ['nullable', 'numeric']
            , 'track_code'  => ['string']
            , 'client_name' => ['string', 'regex:[A-z]','required','max:20']
            , 'client_email' => ['email', 'required']
            , 'total_price' => ['numeric']
            , 'details'     => ['string']
        ];
    }
}
