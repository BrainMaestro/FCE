<?php
/**
 * Created by BrainMaestro
 * Date: 12/3/2016
 * Time: 6:24 PM
 */

namespace Fce\Http\Requests;

class EvaluationRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'section_id' => 'required|integer',
            'question_set_id' => 'required|integer',
            'evaluations.*.id' => 'required|integer',
            'evaluations.*.column' => 'required|in:one,two,three,four,five',
            'comment' => 'string',
        ];
    }
}