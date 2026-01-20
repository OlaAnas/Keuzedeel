<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    protected $fillable = ['name'];

    public function classes()
    {
        return $this->hasMany(ClassModel::class);
    }

    public function keuzedelen()
    {
        return $this->hasMany(Keuzedeel::class);
    }
}
