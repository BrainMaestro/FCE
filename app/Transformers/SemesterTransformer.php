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
     * @var array
     */
    protected $defaultIncludes = [
        'questionSets'
    ];

    /**
     * @param Semester $semester
     * @return array
     */
    public function transform(Semester $semester)
    {
        return [
            'id' => (int) $semester->id,
            'season' => $semester->season,
            'year' => (int) $semester->year,
            'current_semester' => (boolean) $semester->current_semester,
        ];
    }

    /**
     * @param Semester $semester
     * @return \League\Fractal\Resource\Collection
     */
    public function includeQuestionSets(Semester $semester)
    {
        return $this->collection($semester->questionSets, new QuestionSetTransformer);
    }
}
