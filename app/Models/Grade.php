<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['evaluation_id', 'enrollment_id', 'score'];

    public function evaluation() { return $this->belongsTo(Evaluation::class); }
    public function enrollment() { return $this->belongsTo(Enrollment::class); }
}
