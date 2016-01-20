<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 7:51 PM
 */

namespace Fce\Repositories;

use Fce\Models\User;
use Fce\Transformers\UserTransformer;
use Illuminate\Pagination\Paginator;

class UsersRepository extends AbstractRepository implements IUsersRepository
{
    protected $user_model;

    public function __construct(User $user)
    {
        $this->user_model = $user;
    }

    public function getUsers($data)
    {
        try {
            Paginator::currentPageResolver(
                function () use ($data) {
                    return $data['offset'];
                }
            );

            if (is_null($data['query'])) {
                $users = $this->user_model->orderBy($data['sort'].$data['order'])
                    ->paginate($data['limit']);
            } else {
                $users = $this->user_model->where('crn', 'like', '%'.$data['query'].'%')
                    ->orderBy($data['sort'].$data['order'])
                    ->paginate($data['limit']);
            }

            if ($users->isEmpty()) {
                return null;
            } else {
                $users = self::setPaginationLinks($users, $data);
                return self::transform($users, new UserTransformer());
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getUserById($user_id)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getUserBySectionId($section_id)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createUser($data)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteUserById($user_id)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateUser($data)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
