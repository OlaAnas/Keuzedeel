<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Waitlist extends Model
{
    protected $table = 'waitlists';

    protected $fillable = [
        'user_id',
        'keuzedeel_id',
        'period_id',
        'preference_order',
        'status',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    /**
     * Get the user on the waitlist.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the keuzedeel for this waitlist entry.
     */
    public function keuzedeel(): BelongsTo
    {
        return $this->belongsTo(Keuzedeel::class);
    }

    /**
     * Get the period for this waitlist entry.
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }
}
