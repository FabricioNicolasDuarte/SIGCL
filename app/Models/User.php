<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes; // Aquí añadimos HasRoles y SoftDeletes

    protected $fillable = [
        'name',
        'last_name',
        'dni',
        'email',
        'password',
        'phone',
        'is_active',
        'avatar',
        'profile_photo_path'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function getAvatarUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : 'https://ui-avatars.com/api/?name='.urlencode($this->name.' '.$this->last_name).'&color=00f5ff&background=0a192f&rounded=true&bold=true';
    }
}
