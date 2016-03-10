<?php
/**
 * Created by BrainMaestro
 * Date: 6/3/2016
 * Time: 2:58 PM
 */

namespace Fce\Http\Requests;

class SemesterStatusRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|string|in:Locked,Open,Done',
        ];
    }
}
