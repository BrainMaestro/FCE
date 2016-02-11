<?php

namespace Fce\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionSet extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name'];

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

    /**
     * The QuestionSet relationship to evaluation
     * A questionSet hasMany evaluation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * The QuestionSet relationship to comment
     * A questionSet hasMany commet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
