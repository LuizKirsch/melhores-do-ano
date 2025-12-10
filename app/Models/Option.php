<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Option extends Model
{
    protected $fillable = ['alternative_id', 'name', 'photo', 'votes'];

    public function alternative(): BelongsTo
    {
        return $this->belongsTo(Alternative::class);
    }
}
