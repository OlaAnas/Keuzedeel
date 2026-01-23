<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Keuzedeel extends Model
{
    protected $table = 'keuzedelen';

    protected $fillable = [
        'code',
        'name',
        'description',
        'min_students',
        'max_students',
        'active',
        'repeatable',
        'study_id',
        'teacher_id',
        'period_id',
    ];

    protected $casts = [
        'active' => 'boolean',
        'repeatable' => 'boolean',
    ];

    /**
     * Get the study that owns the keuzedeel.
     */
    public function study(): BelongsTo
    {
        return $this->belongsTo(Study::class);
    }

    /**
     * Get the teacher who teaches this keuzedeel.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the period for this keuzedeel.
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * Get all enrollments for this keuzedeel.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get all waitlist entries for this keuzedeel.
     */
    public function waitlists(): HasMany
    {
        return $this->hasMany(Waitlist::class);
    }
}
