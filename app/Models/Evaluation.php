<?php

namespace Fce\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'section_id',
        'question_id',
        'one',
        'two',
        'three',
        'four',
        'five',
        'comment'
    ];

    /**
     * The Evaluation relationship to Section
     * A evaluation belongsTo section
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // @TODO Relate evaluation with both Question and QuestionSet
}
