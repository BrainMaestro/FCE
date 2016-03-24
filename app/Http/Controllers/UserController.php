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
        try {
            $school = Input::get('school');

            if ($school) {
                return $this->repository->getUsersBySchool($school);
            }

            return $this->repository->getUsers();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find any users');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not list users');
        }
    }

    /**
     * Get a specific user by their id.
     *
     * @param $id
     * @return array
     */
    public function show($id)
    {
        try {
            return $this->repository->getUserById($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find user');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not show user');
        }
    }

    /**
     * Create a new user.
     *
     * @return array
     */
    public function create()
    {
        try {
            return $this->repository->createUser($this->request->name, $this->request->email, $this->request->password);
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not create user');
        }
    }

    /**
     * Update a user's attributes.
     *
     * @param $id
     * @return array
     */
    public function update($id)
    {
        try {
            if (!$this->repository->updateUser($id, $this->request->all())) {
                return $this->respondUnprocessable('User attributes were not provided');
            }
            
            return $this->respondSuccess('User successfully updated');
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find user');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not update user');
        }
    }

    /**
     * Delete a user.
     *
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        try {
            $this->repository->deleteUser($id);
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not delete user');
        }
    }
}
