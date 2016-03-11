<?php

/* [Created by SkaeX @ 2016-03-07 21:25:48] */

namespace Fce\Http\Requests;

class QuestionSetAddQuestionRequest extends Request
{
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
