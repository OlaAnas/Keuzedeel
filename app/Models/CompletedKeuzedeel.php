<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompletedKeuzedeel extends Model
{
    protected $table = 'completed_keuzedelen';
    protected $fillable = [
        'student_id',
        'keuzedeel_code',
        'keuzedeel_id',
        'completed_at',
        'source'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function keuzedeel()
    {
        return $this->belongsTo(Keuzedeel::class);
    }
}
