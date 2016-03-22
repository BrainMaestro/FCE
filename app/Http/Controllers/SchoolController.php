<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\SchoolRequest;
use Fce\Repositories\Contracts\SchoolRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SchoolController extends Controller
{
    protected $repository;

    public function __construct(SchoolRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        try {
            return $this->repository->getSchools();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find any schools');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not list schools');
        }
    }


    public function show($id)
    {
        try {
            return $this->repository->getSchoolById($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find school');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not show school');
        }
    }

    public function create(SchoolRequest $request)
    {
        try {
            return $this->repository->createSchool($request->school, $request->description);
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not create school');
        }
    }

    public function update(SchoolRequest $request, $id)
    {
        try {
            if (!$this->repository->updateSchool($id, $request->all())) {
                return $this->respondUnprocessable('School attributes were not provided');
            }
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not update school');
        }
    }
}
