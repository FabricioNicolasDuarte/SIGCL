<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'campus_id', 'teacher_id',
        'capacity', 'start_date', 'end_date', 'is_active'
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    // Relación: Un curso pertenece a una Sede
    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    // Relación: Un curso tiene un Profesor (Usuario)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Relación: Un curso tiene muchas inscripciones (alumnos matriculados)
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
    public function courseClasses() {
        return $this->hasMany(CourseClass::class)->orderBy('date', 'asc');
    }

}
