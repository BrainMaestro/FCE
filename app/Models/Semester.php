<?php

namespace Fce\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'season',
        'year',
        'current_semester'
    ];

    /**
     * The Semester relationship to Section
     * A semester hasMany section
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    /**
     * The Semester relationship to QuestionSet
     * A semester belongsToMany questionSet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questionSets()
    {
        return $this->belongsToMany(QuestionSet::class)->withPivot(['evaluation_type', 'status'])->withTimestamps();
    }
}
