<?php

namespace Fce\Http\Requests;

class UserUpdateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'min:3',
            'email' => 'required_with:password|email|regex:/@aun.edu.ng$/',
            'password' => 'required_with:email|min:6|confirmed',
            'active' => 'boolean',
        ];
    }
}
