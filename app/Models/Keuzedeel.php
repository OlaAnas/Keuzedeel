<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuzedeel extends Model
{
    protected $table = 'keuzedelen';
    protected $fillable = [
        'code',
        'name',
        'description',
        'teacher_id',
        'requirement',
        'level',
        'repeatable',
        'state',
        'study_id',
        'period_id',
        'min_students',
        'max_students'
    ];

    public function study()
    {
        return $this->belongsTo(Study::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
