<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\UserCreateRequest;
use Fce\Http\Requests\UserUpdateRequest;
use Fce\Repositories\Contracts\UserRepository;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        try {
            $school = Input::get('school');

            if ($school) {
                return $this->repository->getUsersBySchool($school);
            }

            return $this->repository->getUsers();
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not list users');
        }
    }

    public function show($id)
    {
        try {
            return $this->repository->getUserById($id);
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not find user');
        }
    }

    public function create(UserCreateRequest $request)
    {
        try {
            return $this->repository->createUser($request->name, $request->email, $request->password);
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not create user');
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try {
            if (!$this->repository->updateUser($id, $request->all())) {
                return $this->respondUnprocessable('User attributes were not provided');
            }
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not update user');
        }
    }

    public function destroy($id)
    {
        try {
            $this->repository->deleteUser($id);
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not delete user');
        }
    }
}
