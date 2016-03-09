<?php

/* [Created by SkaeX @ 2016-03-07 21:28:56]  */

namespace Fce\Http\Requests;

use Fce\Http\Requests\Request;

class QuestionSetRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * @todo  User must have admin role
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
            'name' => 'string|required',
        ];
    }
}
