<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\SectionRequest;
use Fce\Repositories\Contracts\SectionRepository;
use Fce\Repositories\Contracts\KeyRepository;
use Fce\Repositories\Contracts\SemesterRepository;
use Fce\Repositories\Contracts\EvaluationRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;

class SectionController extends Controller
{
    protected $repository;
    protected $keyRepository;
    protected $evaluationRepository;
    protected $semesterRepository;
    protected $currentSemester;

    public function __construct(
        SectionRepository $repository,
        KeyRepository $keyRepository,
        EvaluationRepository $evaluationRepository,
        SemesterRepository $semesterRepository
    ) {
        $this->repository = $repository;
        $this->keyRepository = $keyRepository;
        $this->evaluationRepository = $evaluationRepository;
        $this->semesterRepository = $semesterRepository;
    }

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

    public function create(SectionRequest $request)
    {
        try {
            return $this->respondCreated($this->repository->createSection($request->all()));
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not create section');
        }
    }

    public function update(SectionRequest $request, $id)
    {
        try {
            if (!$this->repository->updateSection($id, $request->all())) {
                return $this->respondUnprocessable('Section attribute(s) were not provided');
            }
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find section');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not update section');
        }
    }

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

    public function showReport($id, $questionSetId)
    {
        try {
            return $this->evaluationRepository->getEvaluationsBySectionAndQuestionSet($id, $questionSetId);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find report');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not show report');
        }
    }

    public function showKeys($id)
    {
        try {
            $this->keyRepository->getKeysBySection($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find key(s)');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not show key(s)');
        }
    }
}
