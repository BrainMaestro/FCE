<?php

namespace Fce\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'section_id',
        'question_set_id',
        'comment',
    ];

    /**
     * The Comment relationship to Section
     * A comment belongsTo section.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * The Comment relationship to QuestionSet
     * A comment belongsTo a questionset.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionSet()
    {
        return $this->belongsTo(QuestionSet::class);
    }
}
