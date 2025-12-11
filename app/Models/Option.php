<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    protected $fillable = ['alternative_id', 'name', 'photo', 'votes'];

    public function alternative(): BelongsTo
    {
        return $this->belongsTo(Alternative::class);
    }

    /**
     * Get votes for this option
     */
    public function userVotes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get the vote count for this option
     */
    public function getVoteCountAttribute()
    {
        return $this->userVotes()->count();
    }
}
