<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentRegistration;
use App\Models\QuizAttempt;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $students = StudentRegistration::with([
            'latestSubmittedAttempt'
        ])
            ->withCount('quizAttempts')
            ->get();

        $totalStudents = StudentRegistration::count();
        $attemptedStudents = StudentRegistration::has('quizAttempts')->count();
        $notAttemptedStudents = StudentRegistration::doesntHave('quizAttempts')->count();

        return view('admin.dashboard', compact(
            'students',
            'totalStudents',
            'attemptedStudents',
            'notAttemptedStudents'
        ));
    }

    public function show(StudentRegistration $student)
    {
        $attempts = $student->quizAttempts()->orderBy('attempt_number')->get();

        return view('admin.student-detail', compact('student', 'attempts'));
    }

    public function userAnalytics(StudentRegistration $student)
    {
        $attempts = $student->quizAttempts()
            ->with('answers.question')
            ->orderBy('attempt_number')
            ->get();

        return view('admin.analytics.user', compact('student', 'attempts'));
    }
}
