<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 7:21 PM
 */

namespace Fce\Transformers;

use Fce\Models\School;
use League\Fractal\TransformerAbstract;

class SchoolTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'section'
    ];

    /**
     * @param School $school
     * @return array
     */
    public function transform(School $school)
    {
        return [
            'id' => (int) $school->id,
            'school' => $school->school,
            'description' => $school->description
        ];
    }

    /**
     * @param School $school
     * @return \League\Fractal\Resource\Collection
     */
    public function includeSection(School $school)
    {
        return $this->collection($school->sections, new SectionTransformer);
    }
}
