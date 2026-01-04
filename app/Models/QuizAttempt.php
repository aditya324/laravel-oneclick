<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    //
    protected $fillable = [
        'student_registration_id',
        'score',
        'attempt_number',
        'passed',
        'started_at',
        'submitted_at',
    ];


    public function student()
    {
        return $this->belongsTo(StudentRegistration::class);
    }
    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class);
    }
}
