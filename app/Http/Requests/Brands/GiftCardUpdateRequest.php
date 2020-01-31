<?php

namespace App\Http\Requests\Brands;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GiftCardUpdateRequest extends FormRequest
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
            'gift_name' => ['required',
                Rule::unique('gift_cards', 'gift_name')->whereNot('gift_id', $this->giftCard)
            ],
            'gift_code' => ['required', 'min:6',
                Rule::unique('gift_cards', 'gift_code')->whereNot('gift_id', $this->giftCard)
            ],
            'gift_amount' => 'required|integer',
        ];
    }


}
