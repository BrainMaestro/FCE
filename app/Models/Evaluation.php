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
        'question_set_id',
        'one',
        'two',
        'three',
        'four',
        'five',
    ];

    /**
     * The Evaluation relationship to Section
     * A evaluation belongsTo section.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * The Evaluation relationship to Question
     * A evaluation belongsTo a question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * The Evaluation relationship to QuestionSet
     * A evaluation belongsTo a questionset.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionSet()
    {
        return $this->belongsTo(QuestionSet::class);
    }
}
