<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;

class QuizController extends Controller
{
    /**
     * Start a new quiz attempt
     */
    public function start($studentId)
    {
        $attemptCount = QuizAttempt::where(
            'student_registration_id',
            $studentId
        )->count();

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

    /**
     * Submit quiz attempt
     */
    public function submit(Request $request, $studentId)
    {
        $attempt = QuizAttempt::where('student_registration_id', $studentId)
            ->latest()
            ->firstOrFail();

        // timer check
        if (now()->diffInSeconds($attempt->started_at) > 900) {
            $attempt->update([
                'submitted_at' => now(),
                'passed' => false,
            ]);

            return redirect()->route('quiz.failed');
        }

        $answers = $request->input('answers', []);
        $score = 0;

        foreach ($answers as $questionId => $answer) {
            $question = QuizQuestion::find($questionId);

            $isCorrect = $question &&
                strtolower($question->correct_option) === strtolower($answer);

            QuizAnswer::create([
                'quiz_attempt_id'  => $attempt->id,
                'quiz_question_id' => $questionId,
                'selected_option'  => $answer,
                'is_correct'       => $isCorrect,
            ]);

            if ($isCorrect) {
                $score++;
            }
        }

        // IMPORTANT: 10 questions assumed
        $percentage = ($score / 10) * 100;

        // 🔴 THIS LINE IS WHAT WAS MISSING BEFORE
        $attempt->update([
            'score'        => $score,
            'submitted_at' => now(),
            'passed'       => $percentage >= 75,
        ]);

        if ($percentage >= 75) {
            return redirect()->route('payment.page', $studentId);
        }

        return redirect()->route('quiz.start', $studentId)
            ->with('error', 'Score below 75%. Please try again.');
    }


    /**
     * Failed page
     */
    public function failed()
    {
        return view('failed');
    }
}
