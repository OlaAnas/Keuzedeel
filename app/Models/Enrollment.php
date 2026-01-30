<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $table = 'enrollments';

    protected $fillable = [
        'user_id',
        'keuzedeel_id',
        'period_id',
        'status',
    ];

    /**
     * Get the user who made the enrollment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the keuzedeel for this enrollment.
     */
    public function keuzedeel(): BelongsTo
    {
        return $this->belongsTo(Keuzedeel::class);
    }

    /**
     * Get the period for this enrollment.
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }
}
