<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_id',
        'student_id',
        'status',
        'final_grade',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    // El alumno de esta matriculación
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // ¡EL PUENTE QUE FALTABA! Una matriculación tiene muchas asistencias
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    // ¡ESTE ES EL PUENTE QUE FALTABA!
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
