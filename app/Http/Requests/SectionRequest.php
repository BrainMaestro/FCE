<?php

namespace Fce\Http\Requests;

class SectionRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                // Route::post('/sections', 'SectionController@create');
                return [
                    'crn' => 'required|integer',
                    'course_code' => 'required|string',
                    'semester_id' => 'required|integer',
                    'school_id' => 'required|integer',
                    'course_title' => 'required|string',
                    'class_time' => 'required|string',
                    'location' => 'required|string',
                    'status' => 'required|string',
                    'enrolled' => 'required|integer'
                ];

            case 'PUT':
                // Route::put('/sections/{id}', 'SectionController@update');
                return [
                    'crn' => 'integer',
                    'course_code' => 'string',
                    'course_title' => 'string',
                    'semester_id' => 'integer',
                    'school_id' => 'integer',
                    'class_time' => 'string',
                    'location' => 'string',
                    'status' => 'string',
                    'enrolled' => 'integer'
                ];
        }
    }
}
