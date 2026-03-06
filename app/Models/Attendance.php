<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {
    protected $fillable = ['enrollment_id', 'course_class_id', 'entry_time', 'exit_time', 'status'];

    public function enrollment() { return $this->belongsTo(Enrollment::class); }
    public function courseClass() { return $this->belongsTo(CourseClass::class); }
}
