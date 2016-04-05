<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 2/22/2016
 * Time: 9:02 PM.
 */
namespace Fce\Repositories\Database;

use Fce\Models\Semester;
use Fce\Repositories\Contracts\SemesterRepository;
use Fce\Repositories\Repository;
use Fce\Transformers\QuestionSetTransformer;
use Fce\Transformers\SemesterTransformer;
use Fce\Utility\Status;

class EloquentSemesterRepository extends Repository implements SemesterRepository
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
        return $this->findBy(['current_semester' => true], self::ONE);
    }

    /**
     * Get a single semester by its id.
     *
     * @param $id
     * @return array
     */
    public function getSemesterById($id)
    {
        return $this->find($id);
    }

    /**
     * Set current semester by its id.
     *
     * @param $id
     * @param bool $status
     * @return bool
     */
    public function setCurrentSemester($id, $status = true)
    {
        return $this->update($id, ['current_semester' => $status]);
    }

    /**
     * Create a new semester from the specified attributes.
     *
     * @param $season
     * @param $year
     * @param bool $currentSemester
     * @return array
     */
    public function createSemester($season, $year, $currentSemester = false)
    {
        return $this->create([
            'season' => $season,
            'year' => $year,
            'current_semester' => $currentSemester,
        ]);
    }

    /**
     * Add question set to the semester.
     *
     * @param $id
     * @param $questionSetId
     * @param $evaluationType
     * @return array
     */
    public function addQuestionSet($id, $questionSetId, $evaluationType)
    {
        return $this->model->findOrFail($id)
            ->questionSets()
            ->attach($questionSetId, ['evaluation_type' => $evaluationType]);
    }

    /**
     * Set the status of the semester's question set.
     *
     * @param $id
     * @param $questionSetId
     * @param $status
     * @return bool
     */
    public function setQuestionSetStatus($id, $questionSetId, $status)
    {
        return $this->model->findOrFail($id)->questionSets()->updateExistingPivot(
            $questionSetId, ['status' => $status]
        ) != 0;
    }

    /**
     * Get question set with an open status.
     *
     * @param $id
     * @return array
     */
    public function getOpenQuestionSet($id)
    {
        $questionSet = $this->model->findOrFail($id)
            ->questionSets()
            ->wherePivot('status', Status::OPEN)
            ->first();

        return (new QuestionSetTransformer)->transform($questionSet);
    }
}
