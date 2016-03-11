<?php

/* [Created by SkaeX @ 2016-03-07 21:28:56]  */

namespace Fce\Http\Requests;

class QuestionSetRequest extends Request
{
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
