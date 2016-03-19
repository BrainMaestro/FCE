<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\SectionRequest;
use Fce\Repositories\Contracts\SectionRepository;
use Fce\Repositories\Contracts\KeyRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;

class SectionController extends Controller
{
    protected $repository;

    public function __construct(
        SectionRepository $repository,
        KeyRepository $keyRepository
    ) {
        $this->repository = $repository;
        $this->keyRepository = $keyRepository;
    }

    public function index()
    {
        try {
            $semester = Input::get('semester');
            $school = Input::get('school');

            if ($semester && !$school) {
                return $this->repository->getSectionsBySemester($semester);
            }

            if ($semester && $school) {
                return $this->repository->getSectionsBySemesterAndSchool($semester, $school);
            }

            return $this->respondUnprocessable('Could not find any criteria');
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find such section(s)');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not list section(s)');
        }

    }

    public function show($id)
    {
        try {
            return $this->repository->getSectionById($id);
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not find section');
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
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not update section');
        }
    }

    public function showReport($id)
    {
        try {
            // Will have to update the evaluation repository and come back to this
        } catch (\Exception $e) {
            return $this->repondInternalServerError('Could not show report(s)');
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
