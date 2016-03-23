<?php

namespace Fce\Http\Requests;

use Fce\Http\Requests\Request;

class SectionUpdateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
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
