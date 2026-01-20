<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'enrollment_open'];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function keuzedelen()
    {
        return $this->hasMany(Keuzedeel::class);
    }
}
