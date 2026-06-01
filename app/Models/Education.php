<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'university', 
        'degree', 
        'period', 
        'gpa'
    ];

    // Relasi One-to-Many ke tabel Organizations
    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    // Relasi One-to-Many ke tabel Projects
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
