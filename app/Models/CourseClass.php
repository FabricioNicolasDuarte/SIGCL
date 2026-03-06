<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model {
    protected $fillable = ['training_id', 'name', 'date'];

    public function training() { return $this->belongsTo(Training::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }
}
