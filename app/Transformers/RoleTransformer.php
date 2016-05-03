<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 7:15 PM.
 */
namespace Fce\Transformers;

use Fce\Models\Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'users',
        'permissions',
    ];

    /**
     * @param Role $role
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'id' => (int) $role->id,
            'name' => $role->name,
            'display_name' => $role->display_name,
            'description' => $role->description,
        ];
    }

    /**
     * @param Role $role
     * @return \League\Fractal\Resource\Collection
     */
    public function includeUsers(Role $role)
    {
        return $this->collection($role->users, new UserTransformer);
    }

    /**
     * @param Role $role
     * @return \League\Fractal\Resource\Collection
     */
    public function includePermissions(Role $role)
    {
        return $this->collection($role->permissions, new PermissionTransformer);
    }
}
