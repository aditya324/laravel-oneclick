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
}
