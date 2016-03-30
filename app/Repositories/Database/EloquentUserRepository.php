<?php

/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 7:51 PM.
 */
namespace Fce\Repositories\Database;

use Fce\Models\User;
use Fce\Models\School;
use Fce\Repositories\Repository;
use Fce\Repositories\Contracts\UserRepository;
use Fce\Transformers\UserTransformer;

class EloquentUserRepository extends Repository implements UserRepository
{
    /**
     * Create a new repository instance.
     *
     * @param User $model
     * @param UserTransformer $transformer
     */
    public function __construct(User $model, UserTransformer $transformer)
    {
        $this->model = $model;
        $this->transformer = $transformer;
    }

    /**
     * Get a paginated list of all users.
     *
     * @return array
     */
    public function getUsers()
    {
        return $this->all();
    }

    /**
     * Get all users that belong to a particular school.
     *
     * @param $schoolId
     * @return array
     */
    public function getUsersBySchool($schoolId)
    {
        return $this->transform(School::findOrFail($schoolId)->users()->paginate(15, ['*'], 'page', 1));
    }

    /**
     * Get a single section by its id.
     *
     * @param $id
     * @return array
     */
    public function getUserById($id)
    {
        return $this->find($id);
    }

    /**
     * Create a new user from the specified attributes.
     *
     * @param $name
     * @param $email
     * @param $password
     * @return array
     */
    public function createUser($name, $email, $password)
    {
        return $this->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'remember_token' => str_random(50),
        ]);
    }

    /**
     * Update a user's attributes.
     *
     * @param $id
     * @param array $attributes
     * @return boolean
     */
    public function updateUser($id, array $attributes)
    {
        return $this->update($id, $attributes);
    }

    /**
     * Delete a user to prevent access to the system.
     *
     * @param $id
     * @return boolean
     */
    public function deleteUser($id)
    {
        return $this->model->findOrFail($id)->delete() == 1;
    }
}
