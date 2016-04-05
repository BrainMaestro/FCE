<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\SemesterRequest;
use Fce\Repositories\Contracts\SemesterRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{
    protected $request;
    protected $repository;

    public function __construct(SemesterRequest $request, SemesterRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    /**
     * Get all semesters.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->repository->getSemesters();
    }

    /**
     * Create a new semester from request data after validation.
     * Ensures that the new semester is the only current semester if specified.
     *
     * @return array
     */
    public function create()
    {
        $semester = $this->repository->createSemester(
            $this->request->season,
            $this->request->year,
            $this->request->current_semester
        );

        // If this is the new current semester, unset the old current semester.
        if ($this->request->current_semester) {
            $this->changeCurrentSemester($semester['data']['id']);
        }

        return $this->respondCreated($semester);
    }

    /**
     * Update the specified semester.
     *
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $this->changeCurrentSemester($id, $this->request->current_semester);

        return $this->respondSuccess('Semester successfully updated');
    }

    /**
     * Add a question set to the semester.
     *
     * @param $id
     * @return array
     */
    public function addQuestionSet($id)
    {
        $this->repository->addQuestionSet(
            $id,
            $this->request->question_set_id,
            $this->request->evaluation_type
        );

        return $this->respondSuccess('Question set successfully added to semester');
    }

    /**
     * Update the question set status.
     *
     * @param $id
     * @param $questionSetId
     * @return array
     */
    public function updateQuestionSetStatus($id, $questionSetId)
    {
        $this->repository->setQuestionSetStatus(
            $id,
            $questionSetId,
            $this->request->status
        );

        return $this->respondSuccess('Question set status successfully updated');
    }

    /**
     * Changes the current semester to the specified one.
     *
     * @param $id
     * @param bool $status
     * @return bool
     * @throws \Exception
     */
    private function changeCurrentSemester($id, $status = true)
    {
        // If we only choose to unset the specified semester.
        if (! $status) {
            return $this->repository->setCurrentSemester($id, false);
        }

        DB::transaction(function() use ($id) {
            try {
                $currentSemester = $this->repository->getCurrentSemester();
                $currentSemesterId = $currentSemester['data']['id'];
    
                // This is already the current semester. No need to perform this operation.
                if ($currentSemesterId == $id) {
                    return false;
                }
    
                // Unset the current semester.
                $this->repository->setCurrentSemester($currentSemesterId, false);
            } catch (ModelNotFoundException $e) {
                // No current semester set. Safe to ignore.
            }
        });

        return $this->repository->setCurrentSemester($id);
    }
}
