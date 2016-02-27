<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 7:51 PM
 */

namespace Fce\Repositories\Database;

use Fce\Models\User;
use Fce\Repositories\Repository;
use Fce\Repositories\Contracts\UserRepository;
use Fce\Transformers\UserTransformer;

class EloquentUserRepository extends Repository implements UserRepository
{
    /**
     * The transformer registered on the repository.
     *
     * @var \League\Fractal\TransformerAbstract
     */
    protected static $transformer = UserTransformer::class;

    /**
     * Get an instance of the registered model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getModel()
    {
        return new User;
    }

    /**
     * Get a paginated list of all users
     *
     * @return array
     */
    public function getUsers()
    {
        return $this->all();
    }

    /**
     * Get all users that belong to a particular school
     *
     * @param $schoolId
     * @return array
     */
    public function getUsersBySchool($schoolId)
    {
        return $this->findBy(['school_id' => $schoolId]);
    }

    /**
     * Get a single section by its id
     *
     * @param $id
     * @return array
     */
    public function getUserById($id)
    {
        return $this->find($id);
    }

    /**
     * Create a new user from the specified attributes
     *
     * @param array $attributes
     * @return static
     */
    public function createUser(array $attributes)
    {
        return $this->create($attributes);
    }

    /**
     * Update a user's attributes
     *
     * @param $id
     * @param array $attributes
     * @return static
     */
    public function updateUser($id, array $attributes)
    {
        return $this->update($id, $attributes);
    }

    /**
     * Delete a user to prevent access to the system
     *
     * @param $id
     * @return static
     */
    public function deleteUser($id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}
