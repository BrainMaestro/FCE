<?php

namespace Fce\Http\Requests;

use Fce\Http\Requests\Request;

class QuestionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * @todo Only User with admin role
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
            'description' => 'required|string',
            'category' => 'string',
            'title' => 'string'
        ];
    }
}
