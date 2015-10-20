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
     * The QuestionMetadata relationship to Question
     * A questionMetadata belongsTo question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questions()
    {
        return $this->belongsToMany('App\Models\Question');
    }
}
