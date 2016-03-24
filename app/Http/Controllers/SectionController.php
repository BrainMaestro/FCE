<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\SectionRequest;
use Fce\Repositories\Contracts\CommentRepository;
use Fce\Repositories\Contracts\EvaluationRepository;
use Fce\Repositories\Contracts\KeyRepository;
use Fce\Repositories\Contracts\SectionRepository;
use Fce\Repositories\Contracts\SemesterRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;

class SectionController extends Controller
{
    protected $request;
    protected $repository;
    protected $semesterRepository;

    public function __construct(
        SectionRequest $request,
        SectionRepository $repository,
        SemesterRepository $semesterRepository
    ) {
        $this->request = $request;
        $this->repository = $repository;
        $this->semesterRepository = $semesterRepository;
    }

    /**
     * Gets section by semester and/or school if both specified or by current semester.
     *
     * @return array
     */
    public function index()
    {
        try {
            $semester = Input::get(
                'semester',
                $this->semesterRepository->getCurrentSemester()['data']['id']
            );
            $school = Input::get('school');

            if ($school) {
                return $this->repository->getSectionsBySemesterAndSchool($semester, $school);
            }

            return $this->repository->getSectionsBySemester($semester);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find section(s)');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not list section(s)');
        }
    }

    /**
     * Gets a section by the specified id.
     *
     * @param  int $id Section's Id
     * @return array
     */
    public function show($id)
    {
        try {
            return $this->repository->getSectionById($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find section');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not show section');
        }
    }

    /**
     * Create a new section.
     *
     * @return mixed
     */
    public function create()
    {
        try {
            return $this->respondCreated($this->repository->createSection($this->request->all()));
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not create section');
        }
    }

    /**
     * Updates a section.
     *
     * @param int $id Section's Id
     * @return array
     */
    public function update($id)
    {
        try {
            if (!$this->repository->updateSection($id, $this->request->all())) {
                return $this->respondUnprocessable('Section attribute(s) were not provided');
            }

            return $this->respondSuccess('Section was updated successfully');
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find section');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not update section');
        }
    }

    /**
     * List reports of the Section.
     *
     * @param int $id Section's Id
     * @return array
     */
    public function listReports($id)
    {
        try {
            $section = $this->repository->getSectionById($id)['data'];

            $semester = $this->semesterRepository->getSemesterById($section['semester_id']);

            return $semester['data']['questionSets'];
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find section');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not list reports');
        }
    }

    /**
     * Shows report of the a section for a question-set.
     *
     * @param EvaluationRepository $evaluationRepository
     * @param CommentRepository $commentRepository
     * @param  $id Section's Id
     * @param  $questionSetId Question Set's Id
     * @return array
     */
    public function showReport(
        EvaluationRepository $evaluationRepository,
        CommentRepository $commentRepository,
        $id,
        $questionSetId
    ) {
        try {
            $evaluations = $evaluationRepository->getEvaluationsBySectionAndQuestionSet($id, $questionSetId);
            $comments = $commentRepository->getComments($id, $questionSetId);
            
            return $this->respondSuccess([
                'evaluations' => $evaluations,
                'comments' => $comments,
            ]);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find report');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not show report');
        }
    }

    /**
     * Gets keys for the given section.
     *
     * @param KeyRepository $keyRepository
     * @param $id Section's Id
     * @return array
     */
    public function showKeys(KeyRepository $keyRepository, $id)
    {
        try {
            return $keyRepository->getKeysBySection($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find key(s)');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not show key(s)');
        }
    }
}
