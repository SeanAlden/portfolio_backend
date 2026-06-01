<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    protected $table = 'personal_infos'; // Laravel biasanya otomatis, tapi baik untuk dipertegas

    protected $fillable = [
        'name', 
        'location', 
        'phone', 
        'email', 
        'linkedin', 
        'github', 
        'summary', 
        'photo'
    ];
}
