<?php

namespace App\Http\Requests\Api\Posts;

use App\Models\Post;
use InfyOm\Generator\Request\APIRequest;

class CreatePostAPIRequest extends APIRequest
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
        return Post::$rules;
    }
}
