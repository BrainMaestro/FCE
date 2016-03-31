<?php

/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 7:01 PM.
 */
namespace Fce\Transformers;

use Fce\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'schools',
    ];

    /**
     * @var array
     */
    protected $availableIncludes = [
        'role',
    ];

    /**
     * @param User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int) $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'active' => (bool) $user->active,
        ];
    }

    /**
     * @param User $user
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeSchools(User $user)
    {
        return $this->collection($user->schools, new SchoolTransformer);
    }

    /**
     * @param User $user
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeRole(User $user)
    {
        return $this->collection($user->roles, new RoleTransformer);
    }
}
