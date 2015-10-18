<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 10:03 PM
 */

namespace app\Transformers;


use App\Models\Section;
use League\Fractal\TransformerAbstract;

class SectionTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'school',
        'evaluation'
    ];

    /**
     * @param Section $section
     * @return array
     */
    public function transform(Section $section)
    {
        return [
            'id' => (int) $section->id,
            'crn' => (int) $section->crn,
            'course_code' => (string) $section->course_code,
            'semester' => (string) $section->semester,
            'school' => (string) $section->school->school,
            'course_title' => (string) $section->course_title,
            'class_time' => (string) $section->class_time,
            'location' => (string) $section->location,
            'locked' => (boolean) $section->locked,
            'enrolled' => (int) $section->enrolled,
            'mid_evaluation' => (boolean) $section->mid_evaluation,
            'final_evaluation' => (boolean) $section->final_evaluation,
            'created_at' => $section->created_at,
            'updated_at' => $section->updated_at,
            'deleted_at' => $section->deleted_at
        ];
    }

    /**
     * @param Section $section
     * @return \League\Fractal\Resource\Item
     */
    public function includeSchool(Section $section)
    {
        $school = $section->school;
        return $this->item($school, new SchoolTransformer);
    }

    /**
     * @param Section $section
     * @return \League\Fractal\Resource\Collection
     */
    public function includeEvaluation(Section $section)
    {
        $evaluations = $section->evaluations;
        return $this->collection($evaluations, new EvaluationTransformer);
    }
}