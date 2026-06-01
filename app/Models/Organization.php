<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'education_id', 
        'name', 
        'role', 
        'period', 
        'points'
    ];

    // Casting JSON to Array agar otomatis menjadi array di PHP
    protected $casts = [
        'points' => 'array',
    ];

    // Relasi Inverse One-to-Many (BelongsTo) ke tabel Education
    public function education()
    {
        return $this->belongsTo(Education::class);
    }
}
