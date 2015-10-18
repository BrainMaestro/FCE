<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 7:01 PM
 */

namespace app\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'role'
    ];

    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'deleted_at' => $user->deleted_at
        ];
    }

    /**
     * @param User $user
     * @return \League\Fractal\Resource\Collection
     */
    public function includeRole(User $user)
    {
        $roles = $user->roles;
        return $this->collection($roles, new RoleTransformer);
    }
}