<?php

namespace Fce\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category', 'title', 'description'];

    /**
     * The Question relationship to QuestionSet
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function questionSets()
    {
        return $this->belongsToMany(QuestionSet::class)->withPivot('position')->withTimestamps();
    }

    /**
     * The Question relationship to Evaluation
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
