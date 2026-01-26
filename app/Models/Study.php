<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Study extends Model
{
    protected $table = 'studies';

    protected $fillable = [
        'name',
    ];

    /**
     * Get all keuzedelen for this study.
     */
    public function keuzedelen(): HasMany
    {
        return $this->hasMany(Keuzedeel::class);
    }
}
