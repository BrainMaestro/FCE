<?php
/**
 * Created by BrainMaestro
 * Date: 6/3/2016
 * Time: 2:58 PM
 */

namespace Fce\Http\Requests;

class SemesterQuestionSetRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question_set_id' => 'required|integer',
            'evaluation_type' => 'required|string|min:3',
        ];
    }
}
