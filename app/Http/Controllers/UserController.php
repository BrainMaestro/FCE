<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\UserRequest;
use Fce\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    protected $request;
    protected $repository;

    public function __construct(UserRequest $request, UserRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    /**
     * Get all users.
     * If specified, the school is used to limit results.
     *
     * @return array
     */
    public function index()
    {
        $school = Input::get('school');

        if ($school) {
            return $this->repository->getUsersBySchool($school);
        }

        return $this->repository->getUsers();
    }

    /**
     * Get a specific user by their id.
     *
     * @param $id
     * @return array
     */
    public function show($id)
    {
        return $this->repository->getUserById($id);
    }

    /**
     * Create a new user.
     *
     * @return array
     */
    public function create()
    {
        return $this->repository->createUser($this->request->name, $this->request->email, $this->request->password);
    }

    /**
     * Update a user's attributes.
     *
     * @param $id
     * @return array
     */
    public function update($id)
    {
        if (! $this->repository->updateUser($id, $this->request->all())) {
            return $this->respondUnprocessable('User attributes were not provided');
        }

        return $this->respondSuccess('User successfully updated');
    }

    /**
     * Delete a user.
     *
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $this->repository->deleteUser($id);
    }
}
