<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = [
        'uploaded_by',
        'original_filename',
        'file_hash',
        'status',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
