<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 4/3/2016
 * Time: 7:41 PM.
 */
namespace Fce\Transformers;

use Fce\Models\Permission;
use League\Fractal\TransformerAbstract;

class PermissionTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'roles',
    ];

    /**
     * @param Permission $permission
     * @return array
     */
    public function transform(Permission $permission)
    {
        return [
            'id' => (int) $permission->id,
            'name' => $permission->name,
            'display_name' => $permission->display_name,
            'description' => $permission->description,
        ];
    }

    /**
     * @param Permission $permission
     * @return \League\Fractal\Resource\Collection
     */
    public function includeRoles(Permission $permission)
    {
        return $this->collection($permission->roles, new RoleTransformer);
    }
}
