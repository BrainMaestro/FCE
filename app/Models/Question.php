<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type'];

    /**
     * The Question relationship to QuestionMetadata
     * A question hasMany questionMetadata
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionMetadata()
    {
        return $this->hasMany('App\Models\QuestionMetadata');
    }

    /**
     * The Question relationship to evaluation
     * A question hasMany evaluation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluations()
    {
        return $this->hasMany('App\Models\Evaluation');
    }
}
