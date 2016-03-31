<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 8:34 PM.
 */
namespace Fce\Repositories\Database;

use Fce\Models\School;
use Fce\Repositories\Contracts\SchoolRepository;
use Fce\Repositories\Repository;
use Fce\Transformers\SchoolTransformer;

class EloquentSchoolRepository extends Repository implements SchoolRepository
{
    /**
     * Create a new repository instance.
     *
     * @param School $model
     * @param SchoolTransformer $transformer
     */
    public function __construct(School $model, SchoolTransformer $transformer)
    {
        $this->model = $model;
        $this->transformer = $transformer;
    }

    /**
     * Get all schools.
     *
     * @return mixed
     */
    public function getSchools()
    {
        return $this->all();
    }

    /**
     * Get a single school by its id.
     *
     * @param $id
     * @return array
     */
    public function getSchoolById($id)
    {
        return $this->find($id);
    }

    /**
     * Creates a new school from the specified attributes.
     *
     * @param $school
     * @param $description
     * @return array
     */
    public function createSchool($school, $description)
    {
        return $this->create([
            'school' => $school,
            'description' => $description,
        ]);
    }

    /**
     * Update a school's attributes.
     *
     * @param $id
     * @param array $attributes
     * @return bool
     */
    public function updateSchool($id, array $attributes)
    {
        return $this->update($id, $attributes);
    }
}
