<?php
/**
 * Created by BrainMaestro
 * Date: 6/3/2016
 * Time: 2:58 PM
 */

namespace Fce\Http\Requests;

class SemesterUpdateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_semester' => 'required|boolean',
        ];
    }
}
