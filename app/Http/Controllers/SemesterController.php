<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\SemesterCreateRequest;
use Fce\Http\Requests\SemesterQuestionSetRequest;
use Fce\Http\Requests\SemesterStatusRequest;
use Fce\Http\Requests\SemesterUpdateRequest;
use Fce\Repositories\Contracts\SemesterRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{
    protected $repository;

    public function __construct(SemesterRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all semesters.
     *
     * @return mixed
     */
    public function index()
    {
        try {
            return $this->repository->getSemesters();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find any semesters');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not list semesters');
        }
    }

    /**
     * Create a new semester from request data after validation.
     * Ensures that the new semester is the only current semester if specified.
     *
     * @param SemesterCreateRequest $request
     * @return mixed
     */
    public function create(SemesterCreateRequest $request)
    {
        try {
            $semester = $this->repository->createSemester(
                $request->season,
                $request->year,
                $request->current_semester
            );

            // If this is the new current semester, unset the old current semester.
            if ($request->current_semester) {
                $this->changeCurrentSemester($semester['data']['id']);
            }

            return $this->respondCreated($semester);
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not create semester');
        }
    }

    /**
     * Update the specified semester.
     *
     * @param SemesterUpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function update(SemesterUpdateRequest $request, $id)
    {
        try {
            $this->changeCurrentSemester($id, $request->current_semester);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Semester does not exist');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not update semester');
        }
    }

    /**
     * Add a question set to the semester.
     *
     * @param SemesterQuestionSetRequest $request
     * @param $id
     * @return mixed
     */
    public function addQuestionSet(SemesterQuestionSetRequest $request, $id)
    {
        try {
            $this->repository->addQuestionSet(
                $id,
                $request->question_set_id,
                $request->evaluation_type
            );
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Semester does not exist');
        } catch (QueryException $e) {
            return $this->respondUnprocessable('Question set does not exist');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not add question set to semester');
        }
    }

    /**
     * Update the question set status.
     *
     * @param SemesterStatusRequest $request
     * @param $id
     * @param $questionSetId
     * @return mixed
     */
    public function updateQuestionSetStatus(SemesterStatusRequest $request, $id, $questionSetId)
    {
        try {
            $this->repository->setQuestionSetStatus(
                $id,
                $questionSetId,
                $request->status
            );
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Semester does not exist');
        } catch (QueryException $e) {
            return $this->respondUnprocessable('Question set does not exist');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not update question set status');
        }
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
        if (!$status) {
            return $this->repository->setCurrentSemester($id, false);
        }

        DB::beginTransaction();
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
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $this->repository->setCurrentSemester($id);
    }
}
