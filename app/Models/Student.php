<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'email',
        'class_id',
        'is_active'
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function completedKeuzedelen()
    {
        return $this->hasMany(CompletedKeuzedeel::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
