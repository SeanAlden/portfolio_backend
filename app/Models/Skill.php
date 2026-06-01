<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'skill_category_id', 
        'name', 
        'percentage'
    ];

    // Relasi Inverse One-to-Many (BelongsTo) ke tabel SkillCategory
    public function skillCategory()
    {
        return $this->belongsTo(SkillCategory::class);
    }
}
