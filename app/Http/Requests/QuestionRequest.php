<?php

namespace Fce\Http\Requests;

class QuestionRequest extends Request
{
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
