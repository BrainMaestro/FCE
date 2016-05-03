<?php

namespace Fce\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description'];

    /**
     * The Role relationship to User
     * A role can belong to many users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The Role relationship to Permission
     * A permission can belong to many users.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
