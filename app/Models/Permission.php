<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 4/3/2016
 * Time: 7:35 PM.
 */
namespace Fce\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description'];

    /**
     * The Permission relationship to Role
     * A permission can belong to many roles.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
