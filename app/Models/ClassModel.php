<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $fillable = ['name', 'study_id'];

    public function study()
    {
        return $this->belongsTo(Study::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
