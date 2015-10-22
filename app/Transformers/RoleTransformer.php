<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 7:15 PM
 */

namespace App\Transformers;

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
            'role' => $role->role,
            'display_name' => $role->display_name,
        ];
    }

    /**
     * @param Role $role
     * @return \League\Fractal\Resource\Collection
     */
    public function includeUser(Role $role)
    {
        return $this->collection($role->users, new UserTransformer());
    }
}