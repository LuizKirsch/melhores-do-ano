<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alternative extends Model
{
    protected $fillable = ['title', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }
}
