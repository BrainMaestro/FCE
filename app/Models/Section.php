<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'crn',
        'course_code',
        'semester',
        'school',
        'course_title',
        'class_time',
        'location',
        'locked',
        'enrolled',
        'midterm_evaluation',
        'final_evaluation'
    ];

    /**
     * The Section relationship to School
     * A section belongsTo school
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }

    /**
     * The Section relationship to evaluation
     * A section hasMany evaluation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluations()
    {
        return $this->hasMany('App\Models\Evaluation');
    }

    /**
     * The Section relationship to Semester
     * A section belongsTo semester
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function semester()
    {
        return $this->belongsTo('App\Models\Semester');
    }
}
