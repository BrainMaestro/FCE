<?php

namespace Fce\Models;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['value', 'section_id'];

    /**
     * The Key relationship to Section
     * A key belongsTo a section
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
