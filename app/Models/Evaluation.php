<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['training_id', 'name', 'max_score', 'date'];

    public function training() { return $this->belongsTo(Training::class); }
    public function grades() { return $this->hasMany(Grade::class); }
}
