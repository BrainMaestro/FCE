<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionMetadata extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['question_id', 'number', 'category', 'title', 'description'];

    /**
     * The parent 'updated_at' is used
     *
     * @var array
     */
    protected $touches = ['question'];

    /**
     * The QuestionMetadata relationship to Question
     * A questionMetadata belongsTo question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }

    /**
     * The QuestionMetadata relationship to evaluation
     * A questionMetadata hasMany evaluation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluations()
    {
        return $this->hasMany('App\Models\Evaluation', 'question_metadata_id');
    }
}
