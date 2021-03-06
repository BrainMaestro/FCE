<?php

/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 7:51 PM.
 */
namespace Fce\Repositories\Database;

use Carbon\Carbon;
use Fce\Models\Role;
use Fce\Models\User;
use Fce\Models\School;
use Fce\Repositories\Repository;
use Fce\Repositories\Contracts\UserRepository;
use Fce\Transformers\UserTransformer;
use Illuminate\Support\Facades\Input;

class EloquentUserRepository extends Repository implements UserRepository
{
    const PASSKEY_LENGTH = 6;

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

        // Get only active users by default.
        Input::merge(['active' => true]);
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
     * Get all helper users.
     *
     * @return array
     */
    public function getHelperUsers()
    {
        // Helper users are not active by default.
        Input::merge(['active' => false]);

        return $this->findBy(['name' => 'helper']);
    }

    /**
     * Get all users that belong to a particular school.
     *
     * @param $schoolId
     * @return array
     */
    public function getUsersBySchool($schoolId)
    {
        // TODO Find a better way to do this.
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
     * Create a new set of helper users.
     *
     * @param array $sections
     * @return bool
     */
    public function createHelperUsers(array $sections)
    {
        $helpers = [];
        $passkeys = [];
        $now = Carbon::now('utc');

        foreach ($sections as $section) {
            do {
                $passkey = strtoupper(str_random(self::PASSKEY_LENGTH));
            } while (in_array($passkey, $passkeys));

            $helpers[] = [
                'name' => $section['course_code'] . ' helper',
                'email' => 'helper.' . $section['id'] . '@aun.edu.ng',
                'password' => bcrypt($passkey),
                'active' => false, // To prevent retrieving with regular users.
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $this->model->insert($helpers);
    }

    /**
     * Update a user's attributes.
     *
     * @param $id
     * @param array $attributes
     * @return bool
     */
    public function updateUser($id, array $attributes)
    {
        return $this->update($id, $attributes);
    }

    /**
     * Delete a user to prevent access to the system.
     *
     * @param $id
     * @return bool
     */
    public function deleteUser($id)
    {
        return $this->model->findOrFail($id)->delete() == 1;
    }

    /**
     * Delete all the helper users.
     *
     * @return bool
     */
    public function deleteHelperUsers()
    {
        return $this->model->where('name', 'LIKE', '%helper')->forceDelete() > 0;
    }

    /**
     * Add a role used for user access.
     *
     * @param $id
     * @param $role
     * @return bool
     */
    public function addRole($id, $role)
    {
        return $this->model->findOrFail($id)->attachRole($role) == null;
    }

    /**
     * Add a permission to a role.
     *
     * @param $roleId
     * @param $permission
     * @return bool
     */
    public function addPermission($roleId, $permission)
    {
        return Role::findOrFail($roleId)->attachPermission($permission) == null;
    }
}
