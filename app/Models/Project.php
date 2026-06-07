<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = ['education_id', 'name', 'desc', 'tech', 'github_urls', 'image'];

    protected $casts = [
        'tech' => 'array',
        'github_urls' => 'array',
    ];
}
