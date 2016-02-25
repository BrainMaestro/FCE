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

class EloquentSemesterRepository extends Repository implements SemesterRepository
{
    /**
     * The transformer registered on the repository.
     *
     * @var \League\Fractal\TransformerAbstract
     */
    protected static $transformer = SemesterTransformer::class;

    /**
     * Get an instance of the registered model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getModel()
    {
        return new Semester();
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
     * @param bool $status
     * @return mixed
     */
    public function getCurrentSemester($status = true)
    {
        return $this->findBy(['current_semester' => $status], 'one');
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
     * @return static
     */
    public function createSemester(array $attributes)
    {
        return $this->create($attributes);
    }

    /**
     * Add question set to the semester.
     *
     * @param $id
     * @param array $questionSetIds
     * @return array
     */
    public function addQuestionSet($id, array $questionSetIds)
    {
        return $this->model->findOrFail($id)->questionSets()->attach($questionSetIds);
    }
}
