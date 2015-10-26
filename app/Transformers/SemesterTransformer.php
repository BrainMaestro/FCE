<?php
/**
 * Created by PhpStorm.
 * Semester: Maestro
 * Date: 22/10/2015
 * Time: 8:49 PM
 */

namespace Fce\Transformers;

use Fce\Models\Semester;
use League\Fractal\TransformerAbstract;

class SemesterTransformer extends TransformerAbstract
{
    /**
     * @param Semester $semester
     * @return array
     */
    public function transform(Semester $semester)
    {
        return [
            'id' => (int) $semester->id,
            'semester' => $semester->semester,
            'current_semester' => (boolean) $semester->current_semester,
        ];
    }
}