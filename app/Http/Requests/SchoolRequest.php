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
        switch ($this->method()) {
            case 'POST':
                // Route::post('/schools', 'SchoolController@create');
                return [
                    'school' => 'required|min:2',
                    'description' => 'required|string',
                ];

            case 'PUT':
                // Route::put('/schools/{id}', 'SchoolController@update');
                return [
                    'school' => 'string|min:2',
                    'description' => 'string',
                ];
        }
        
        return [];
    }
}
