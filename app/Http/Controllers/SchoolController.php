<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\SchoolRequest;
use Fce\Repositories\Contracts\SchoolRepository;

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
        return $this->repository->getSchools();
    }

    /**
     * Get a specific school by its id.
     *
     * @param $id
     * @return array
     */
    public function show($id)
    {
        return $this->repository->getSchoolById($id);
    }

    /**
     * Create a new school.
     *
     * @return array
     */
    public function create()
    {
        return $this->respondCreated(
            $this->repository->createSchool($this->request->school, $this->request->description)
        );
    }

    /**
     * Update the attributes of an existing school.
     *
     * @param $id
     * @return array
     */
    public function update($id)
    {
        if (! $this->repository->updateSchool($id, $this->request->all())) {
            return $this->respondUnprocessable('School attributes were not provided');
        }

        return $this->respondSuccess('School successfully updated');
    }
}
