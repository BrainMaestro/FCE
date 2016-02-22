<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 8:34 PM
 */

namespace Fce\Repositories\Database;

use Fce\Models\School;
use Fce\Repositories\Contracts\SchoolRepository;
use Fce\Repositories\Repository;
use Fce\Transformers\SchoolTransformer;

class SQLSchoolRepository extends Repository implements SchoolRepository
{
    /**
     * The transformer registered on the repository.
     *
     * @var \League\Fractal\TransformerAbstract
     */
    protected static $transformer = SchoolTransformer::class;

    /**
     * Get an instance of the registered model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getModel()
    {
        return new School;
    }

    /**
     * Get all schools
     *
     * @return mixed
     */
    public function getSchools()
    {
        return $this->all();
    }

    /**
     * Get a single school by its id
     *
     * @param $id
     * @return mixed
     */
    public function getSchoolById($id)
    {
        return $this->find($id);
    }

    /**
     * Creates a new school from the specified attributes
     *
     * @param array $attributes
     * @return static
     */
    public function createSchool(array $attributes)
    {
        return $this->create($attributes);
    }

    /**
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function updateSchool($id, array $attributes)
    {
        return $this->update($id, $attributes);
    }
}
