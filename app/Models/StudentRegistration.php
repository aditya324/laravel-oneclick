<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
    //

    protected $fillable = [
        'name',
        'phone',
        'email',
        'college_id_path',
    ];


    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_registration_id');
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class, 'student_registration_id')->latestOfMany();
    }


    public function latestSubmittedAttempt()
    {
        return $this->hasOne(QuizAttempt::class)
            ->whereNotNull('submitted_at')
            ->latest('submitted_at');
    }
}
