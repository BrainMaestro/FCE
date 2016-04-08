<?php

namespace Fce\Http\Controllers;

use Fce\Events\Event;
use Fce\Http\Requests\SectionRequest;
use Fce\Repositories\Contracts\CommentRepository;
use Fce\Repositories\Contracts\EvaluationRepository;
use Fce\Repositories\Contracts\KeyRepository;
use Fce\Repositories\Contracts\SectionRepository;
use Fce\Repositories\Contracts\SemesterRepository;
use Fce\Utility\Status;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
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
        $semester = Input::get(
            'semester',
            $this->semesterRepository->getCurrentSemester()['data']['id']
        );
        $school = Input::get('school');

        if ($school) {
            return $this->repository->getSectionsBySemesterAndSchool($semester, $school);
        }

        return $this->repository->getSectionsBySemester($semester);
    }

    /**
     * Gets a section by the specified id.
     *
     * @param  int $id Section's Id
     * @return array
     */
    public function show($id)
    {
        return $this->repository->getSectionById($id);
    }

    /**
     * Create a new section.
     *
     * @return mixed
     */
    public function create()
    {
        return $this->respondCreated($this->repository->createSection($this->request->all()));
    }

    /**
     * Updates a section.
     *
     * @param int $id Section's Id
     * @return array
     */
    public function update($id)
    {
        if (! $this->repository->updateSection($id, $this->request->except('status'))) {
            return $this->respondUnprocessable('Section attribute(s) were not provided');
        }

        return $this->respondSuccess('Section was updated successfully');
    }

    /**
     * Update a section's status.
     *
     * @param $id
     * @return array
     */
    public function updateStatus($id)
    {
        $section = $this->repository->getSectionById($id)['data'];
        $status = $this->request->only('status');

        // Prevent a section's status from changing to the same value.
        if ($section['status'] === $status['status']) {
            return $this->respondUnprocessable('Section is already ' . $section['status']);
        }

        DB::transaction(function () use ($id, $status) {
            // Update the section status.
            $this->repository->updateSection($id, $status);

            // Fire relevant events based on the status type.
            switch ($status['status']) {
                case Status::OPEN:
                    event(Event::SECTION_OPENED, $id);
                    break;

                case Status::DONE:
                    event(Event::SECTION_CLOSED, $id);
                    break;
            }
        });

        return $this->respondSuccess('Section status updated successfully');
    }

    /**
     * List reports of the Section.
     *
     * @param int $id Section's Id
     * @return array
     */
    public function listReports($id)
    {
        $section = $this->repository->getSectionById($id)['data'];

        $semester = $this->semesterRepository->getSemesterById($section['semester_id']);

        return $semester['data']['questionSets'];
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
        $evaluations = $evaluationRepository->getEvaluationsBySectionAndQuestionSet($id, $questionSetId);

        $comments = [];
        try {
            $comments = $commentRepository->getComments($id, $questionSetId);
        } catch (ModelNotFoundException $e) {
        } // Safe to ignore if there are no comments.

        return $this->respondSuccess([
            'evaluations' => $evaluations,
            'comments' => $comments,
        ]);
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
        return $keyRepository->getKeysBySection($id);
    }
}
