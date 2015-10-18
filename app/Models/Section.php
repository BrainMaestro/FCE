<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

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
        'mid_evaluation',
        'final_evaluation'
    ];

    /**
     * The parent 'updated_at' is used
     *
     * @var array
     */
    protected $touches = ['school'];

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
}
