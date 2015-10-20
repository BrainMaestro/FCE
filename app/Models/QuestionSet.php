<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionSet extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['type'];

    /**
     * The QuestionSet relationship to Question
     * A questionSet belongsToMany questions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    /**
     * The QuestionSet relationship to Semester
     * A questionSet belongsToMany semesters
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function semesters()
    {
        return $this->belongsToMany(Semester::class);
    }
}
