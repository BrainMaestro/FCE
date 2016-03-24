<?php

namespace Fce\Http\Requests;

class UserRequest extends Request
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
                // Route::post('/users', 'UserController@create');
                return [
                    'name' => 'required|min:3',
                    'email' => 'required|email|regex:/@aun.edu.ng$/',
                    'password' => 'required|min:6|confirmed',
                ];
            
            case 'PUT':
                // Route::put('/users/{id}', 'UserController@update');
                return [
                    'name' => 'min:3',
                    'email' => 'required_with:password|email|regex:/@aun.edu.ng$/',
                    'password' => 'required_with:email|min:6|confirmed',
                    'active' => 'boolean',
                ];
        }
    }
}
