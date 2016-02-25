<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 2/22/2016
 * Time: 9:02 PM
 */

namespace Fce\Repositories\Database;

use Fce\Models\Semester;
use Fce\Repositories\Contracts\SemesterRepository;
use Fce\Repositories\Repository;
use Fce\Transformers\SemesterTransformer;

class SQLSemesterRepository extends Repository implements SemesterRepository
{
    /**
     * Create a new repository instance.
     *
     * @param Semester $model
     * @param SemesterTransformer $transformer
     */
    public function __construct(Semester $model, SemesterTransformer $transformer)
    {
        $this->model = $model;
        $this->transformer = $transformer;
    }

    /**
     * Get all semesters.
     *
     * @return mixed
     */
    public function getSemesters()
    {
        return $this->all();
    }

    /**
     * Get current semester.
     *
     * @return mixed
     */
    public function getCurrentSemester()
    {
        return $this->findBy(['current_semester' => true], 'one');
    }

    /**
     * Set current semester by its id.
     *
     * @param $id
     * @return boolean
     */
    public function setCurrentSemester($id)
    {
        return $this->update($id, ['current_semester' => true]);
    }

    /**
     * Creates a new semester from the specified attributes.
     *
     * @param array $attributes
     * @return array
     */
    public function createSemester(array $attributes)
    {
        return $this->create($attributes);
    }
}
