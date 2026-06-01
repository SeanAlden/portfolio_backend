<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = ['title', 'type', 'period', 'points'];

    // Casting JSON to Array
    protected $casts = [
        'points' => 'array',
    ];
}
