<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 7:21 PM
 */

namespace app\Transformers;

use App\Models\School;
use League\Fractal\TransformerAbstract;

class SchoolTransformer extends TransformerAbstract
{
    /**
     * @param School $school
     * @return array
     */
    public function transform(School $school)
    {
        return [
            'id' => (int) $school->id,
            'school' => (string) $school->school,
            'description' => (string) $school->description,
            'created_at' => $school->created_at,
            'updated_at' => $school->updated_at,
            'deleted_at' => $school->deleted_at
        ];
    }
}