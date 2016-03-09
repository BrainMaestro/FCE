<?php

/* [Created by SkaeX @ 2016-03-07 21:25:48] */

namespace Fce\Http\Requests;

use Fce\Http\Requests\Request;

class QuestionSetAddQuestionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * @todo User must have admin role
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
            'questions' => 'array|required'
        ];
    }
}
