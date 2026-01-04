<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\DB;

class QuizAnalyticsController extends Controller
{
    //

    public function questions()
    {
        $analytics = QuizQuestion::select(
            'quiz_questions.id',
            'quiz_questions.question',
            DB::raw('COUNT(quiz_answers.id) as total_attempts'),
            DB::raw('SUM(quiz_answers.is_correct = 1) as correct_attempts'),
            DB::raw('SUM(quiz_answers.is_correct = 0) as wrong_attempts'),
            DB::raw('ROUND((SUM(quiz_answers.is_correct = 1) / COUNT(quiz_answers.id)) * 100, 2) as pass_rate')
        )
            ->leftJoin('quiz_answers', 'quiz_questions.id', '=', 'quiz_answers.quiz_question_id')
            ->groupBy('quiz_questions.id', 'quiz_questions.question')
            ->get();

        return view('admin.analytics.questions', compact('analytics'));
    }
}
