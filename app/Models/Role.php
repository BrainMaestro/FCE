<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role', 'display_name'];

    /**
     * The Role relationship to User
     * A role can belong to many users
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
