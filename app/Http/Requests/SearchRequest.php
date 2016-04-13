<?php

namespace Fce\Http\Requests;

class SearchRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Route::get('/search', 'SearchController@index');
        return [
            'model' => 'required|string',
            'query' => 'required|string',
        ];
    }
}
