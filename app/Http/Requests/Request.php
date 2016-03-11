<?php

namespace Fce\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @todo Only User with admin role
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
