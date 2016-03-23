<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\UserCreateRequest;
use Fce\Http\Requests\UserUpdateRequest;
use Fce\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
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
     * @param UserCreateRequest $request
     * @return array
     */
    public function create(UserCreateRequest $request)
    {
        try {
            return $this->repository->createUser($request->name, $request->email, $request->password);
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not create user');
        }
    }

    /**
     * Update a user's attributes.
     *
     * @param UserUpdateRequest $request
     * @param $id
     * @return array
     */
    public function update(UserUpdateRequest $request, $id)
    {
        try {
            if (!$this->repository->updateUser($id, $request->all())) {
                return $this->respondUnprocessable('User attributes were not provided');
            }
            
            return $this->respondSuccess('User successfully updated');
        }  catch (ModelNotFoundException $e) {
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
