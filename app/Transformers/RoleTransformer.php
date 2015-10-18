<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 7:15 PM
 */

namespace app\Transformers;

use App\Models\Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'user'
    ];

    /**
     * @param Role $role
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'id' => (int) $role->id,
            'role' => (string) $role->role,
            'display_name' => (string) $role->display_name,
            'created_at' => $role->created_at,
            'updated_at' => $role->updated_at,
            'deleted_at' => $role->deleted_at
        ];
    }

    /**
     * @param Role $role
     * @return \League\Fractal\Resource\Collection
     */
    public function includeUser(Role $role)
    {
        $users = $role->users;
        return $this->collection($users, new UserTransformer());
    }
}