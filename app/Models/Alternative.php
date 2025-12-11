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

    /**
     * Get votes for this alternative
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Scope para obter apenas alternativas ativas
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope para obter apenas alternativas inativas
     */
    public function scopeInactive($query)
    {
        return $query->where('active', false);
    }

    /**
     * Obtém a alternativa ativa atual (se houver)
     */
    public static function getActive()
    {
        return static::active()->first();
    }
}
