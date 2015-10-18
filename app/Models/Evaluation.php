<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'section_id',
        'question_id',
        'question_metadata_id',
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
        return $this->belongsTo('\App\Models\Section');
    }

    /**
     * The Evaluation relationship to Question
     * A evaluation belongsTo question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }

    /**
     * The Evaluation relationship to QuestionMetadata
     * A evaluation belongsTo questionMetadata
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionMetadata()
    {
        return $this->belongsTo('App\Models\QuestionMetadata');
    }
}
