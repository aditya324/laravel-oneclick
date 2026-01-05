<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use Carbon\Carbon;
use App\Models\QuizAnswer;

class QuizController extends Controller
{
    public function start($studentId)
    {
        $attemptCount = QuizAttempt::where('student_registration_id', $studentId)->count();

        if ($attemptCount >= 3) {
            abort(403, 'Maximum quiz attempts exceeded');
        }

        $attempt = QuizAttempt::create([
            'student_registration_id' => $studentId,
            'attempt_number' => $attemptCount + 1,
            'started_at' => now(),
        ]);

        $questions = QuizQuestion::where('is_active', true)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        return view('quiz', compact('questions', 'studentId', 'attempt'));
    }



    public function submit(Request $request, $studentId)
    {
        $attempt = QuizAttempt::where('student_registration_id', $studentId)
            ->latest()
            ->first();

        // Time validation (15 minutes)
        if (now()->diffInMinutes($attempt->started_at) > 15) {
            return back()->with('error', 'Time expired');
        }

        $score = 0;
        foreach ($request->answers as $questionId => $answer) {
            $question = QuizQuestion::find($questionId);

            $isCorrect = $question && $question->correct_option === $answer;

            QuizAnswer::create([
                'quiz_attempt_id'   => $attempt->id,
                'quiz_question_id'  => $questionId,
                'selected_option'   => $answer,
                'is_correct'        => $isCorrect,
            ]);

            if ($isCorrect) {
                $score++;
            }
        }

        $percentage = ($score / 10) * 100;

        $attempt->update([
            'score' => $score,
            'percentage' => $percentage,
            'submitted_at' => now(),
        ]);

        if ($percentage >= 75) {
            return redirect()->route('payment.page', $studentId);
        }

        if ($attempt->attempt_number >= 3) {
            return redirect()->route('quiz.failed');
        }

        return redirect()->route('quiz.start', $studentId)
            ->with('error', 'Score below 75%. Try again.');
    }


    public function failed()
    {
        return view('failed');
    }
}
