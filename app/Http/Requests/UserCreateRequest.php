<?php

namespace Fce\Http\Requests;

class UserCreateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|regex:/@aun.edu.ng$/',
            'password' => 'required|min:6|confirmed',
        ];
    }
}
