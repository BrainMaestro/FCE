<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 10:03 PM.
 */
namespace Fce\Transformers;

use Fce\Models\Section;
use League\Fractal\TransformerAbstract;

class SectionTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'users',
    ];

    /**
     * @var array
     */
    protected $availableIncludes = [
        'school',
        'evaluation',
        'semester',
        'keys',
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
            'course_code' => $section->course_code,
            'semester_id' => (int) $section->semester_id,
            'school_id' => (int) $section->school_id,
            'course_title' => $section->course_title,
            'class_time' => $section->class_time,
            'location' => $section->location,
            'status' => $section->status,
            'enrolled' => (int) $section->enrolled,
        ];
    }

    /**
     * @param section $section
     * @return \League\Fractal\Resource\Item
     */
    public function includeUsers(Section $section)
    {
        return $this->collection($section->users, new UserTransformer);
    }

    /**
     * @param Section $section
     * @return \League\Fractal\Resource\Item
     */
    public function includeSchool(Section $section)
    {
        return $this->item($section->school, new SchoolTransformer);
    }

    /**
     * @param Section $section
     * @return \League\Fractal\Resource\Collection
     */
    public function includeEvaluation(Section $section)
    {
        return $this->collection($section->evaluations, new EvaluationTransformer);
    }

    /**
     * @param Section $section
     * @return \League\Fractal\Resource\Item
     */
    public function includeSemester(Section $section)
    {
        return $this->item($section->semester, new SemesterTransformer);
    }

    /**
     * @param Section $section
     * @return \League\Fractal\Resource\Collection
     */
    public function includeKey(Section $section)
    {
        return $this->collection($section->keys, new KeyTransformer);
    }
}
