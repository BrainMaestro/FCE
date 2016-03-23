<?php

namespace Fce\Http\Requests;

use Fce\Http\Requests\Request;

class SectionCreateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
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
    }
}
