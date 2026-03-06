<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'latitude',   // ¡Agregado!
        'longitude',  // ¡Agregado!
        'is_active',  // ¡Agregado!
    ];

    // Una sede tiene muchos cursos
    public function trainings()
    {
        return $this->hasMany(Training::class);
    }
}
