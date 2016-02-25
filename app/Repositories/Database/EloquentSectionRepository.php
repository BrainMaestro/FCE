<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 8:04 PM
 */

namespace Fce\Repositories\Database;

use Fce\Models\Section;
use Fce\Repositories\Repository;
use Fce\Repositories\Contracts\SectionRepository;
use Fce\Transformers\SectionTransformer;

class EloquentSectionRepository extends Repository implements SectionRepository
{
    /**
     * Create a new repository instance.
     *
     * @param Section $model
     * @param SectionTransformer $transformer
     */
    public function __construct(Section $model, SectionTransformer $transformer)
    {
        $this->model = $model;
        $this->transformer = $transformer;
    }

    /**
     * Gets all sections by the semester they belong to.
     *
     * @param $semesterId
     * @return array
     */
    public function getSectionsBySemester($semesterId)
    {
        return $this->findBy(['semester_id' => $semesterId]);
    }

    /**
     * Gets all sections by the semester and school they belong to.
     *
     * @param $semesterId
     * @param $schoolId
     * @return array
     */
    public function getSectionsBySemesterAndSchool($semesterId, $schoolId)
    {
        return $this->findBy([
            'semester_id' => $semesterId,
            'school_id' => $schoolId
        ]);
    }

    /**
     * Get a single section by its id.
     *
     * @param $id
     * @return array
     */
    public function getSectionById($id)
    {
        return $this->find($id);
    }

    /**
     * Creates a new section from the specified attributes.
     *
     * @param array $attributes
     * @return array
     */
    public function createSection(array $attributes)
    {
        return $this->create($attributes);
    }

    /**
     * Updates a section's attributes.
     *
     * @param $id
     * @param array $attributes
     * @return array
     */
    public function updateSection($id, array $attributes)
    {
        return $this->update($id, $attributes);
    }

    /**
     * Changes a sections's status.
     *
     * @param $id
     * @param $status
     * @return mixed
     */
    public function setSectionStatus($id, $status)
    {
        if (!in_array($status, Section::STATUSES)) {
            throw new \InvalidArgumentException($status . ' is not an available section status');
        }

        return $this->update($id, ['status' => $status]);
    }
}
