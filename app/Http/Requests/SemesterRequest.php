<?php

namespace Fce\Http\Requests;

use Fce\Utility\Status;

class SemesterRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $path = $this->path();

        switch ($this->method()) {
            case 'POST':
                if (str_is('api/semesters', $path)) {
                    // Route::post('/semesters', 'SemesterController@create');
                    return [
                        'season' => 'required|string|min:3',
                        'year' => 'required|date_format:Y',
                        'current_semester' => 'required|boolean',
                    ];
                }

                if (str_is('api/semesters/*/question_sets', $path)) {
                    // Route::post('/semesters/{id}/question_sets', 'SemesterController@addQuestionSet');
                    return [
                        'question_set_id' => 'required|integer',
                        'evaluation_type' => 'required|string|min:3',
                    ];
                }

                break;
            case 'PUT':
                if (str_is('api/semesters/question_sets/*', $path)) {
                    // Route::put('/semesters/question_sets/{questionSetId}', 'SemesterController@updateQuestionSetStatus');
                    return [
                        'status' => 'required|string|in:'
                            . Status::OPEN . ','
                            . Status::DONE,
                    ];
                }

                if (str_is('api/semesters/*', $path)) {
                    // Route::put('/semesters/{id}', 'SemesterController@update');
                    return [
                        'current_semester' => 'required|boolean',
                    ];
                }

                break;
        }

        return [];
    }
}
