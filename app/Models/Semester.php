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
    protected $fillable = [
        'id',
        'midterm_evaluations',
        'final_evaluations',
        'midterm_question_set',
        'final_question_set'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function midtermQuestionSet()
    {
        return $this->hasOne('App\Models\QuestionSet', 'midterm_question_set');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function finalQuestionSet()
    {
        return $this->hasOne('App\Models\QuestionSet', 'final_question_set');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections()
    {
        return $this->hasMany('App\Models\Section');
    }
}
