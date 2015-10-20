<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['semester'];

    /**
     * The Semester relationship to QuestionSet
     * A semester belongsToMany questionSets
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function questionSets()
    {
        return $this->belongsToMany(QuestionSet::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
