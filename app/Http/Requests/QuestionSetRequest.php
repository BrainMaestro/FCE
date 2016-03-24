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
        $path = $this->path();
        
        if (str_is('api/question-sets/*/questions', $path)) {
            // Route::post('/question-sets/{id}/questions', 'QuestionSetController@addQuestions');
            return [
                'questions' => 'array|required',
            ];
        }
        
        if (str_is('api/question-sets', $path)) {
            //Route::post('/question-sets', 'QuestionSetController@create');
            return [
                'name' => 'string|required',
            ];
        }
    }
}
