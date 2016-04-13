<?php

namespace Fce\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'crn',
        'course_code',
        'semester_id',
        'school_id',
        'course_title',
        'class_time',
        'location',
        'status',
        'enrolled',
    ];

    /**
     * The Section relationship to School
     * A section belongsTo school.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * The Section relationship to evaluation
     * A section hasMany evaluation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * The Section relationship to Semester
     * A section belongsTo semester.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * The Section relationship to key
     * A section hasMany keys.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function keys()
    {
        return $this->hasMany(Key::class);
    }

    /**
     * The Section relationship to User
     * A section can have many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The Section relationship to comment
     * A section hasMany comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
