<?php

namespace Fce\Http\Requests;

class SchoolRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'school' => 'required|min:2',
            'description' => 'required',
        ];
    }
}
