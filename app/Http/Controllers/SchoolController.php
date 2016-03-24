<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\SchoolRequest;
use Fce\Repositories\Contracts\SchoolRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SchoolController extends Controller
{
    protected $request;
    protected $repository;

    public function __construct(SchoolRequest $request, SchoolRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    /**
     * Get all schools.
     *
     * @return array
     */
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

    /**
     * Get a specific school by its id.
     *
     * @param $id
     * @return array
     */
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

    /**
     * Create a new school.
     *
     * @return array
     */
    public function create()
    {
        try {
            return $this->respondCreated(
                $this->repository->createSchool($this->request->school, $this->request->description)
            );
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not create school');
        }
    }

    /**
     * Update the attributes of an existing school.
     *
     * @param $id
     * @return array
     */
    public function update($id)
    {
        try {
            if (!$this->repository->updateSchool($id, $this->request->all())) {
                return $this->respondUnprocessable('School attributes were not provided');
            }
            
            return $this->respondSuccess('School successfully updated');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not update school');
        }
    }
}
