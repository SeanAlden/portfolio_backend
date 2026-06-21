<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; // 1. Tambahkan import ini di atas

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */

    // 2. Tambahkan HasApiTokens di dalam trait "use"
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image',
        'description',
    ];

    // Tambahkan properti ini agar image_url selalu ikut terkirim saat fetch User
    protected $appends = ['image_url'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Accessor untuk S3 URL
    public function getImageUrlAttribute()
    {
        return $this->image ? \Illuminate\Support\Facades\Storage::disk('s3')->url($this->image) : null;
    }
}
