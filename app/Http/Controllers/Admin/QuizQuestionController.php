<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuizQuestion;


class QuizQuestionController extends Controller
{
    public function index()
    {
        $questions = QuizQuestion::latest()->get();
        return view('admin.quiz.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.quiz.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question'        => 'required|string',
            'option_a'        => 'required|string',
            'option_b'        => 'required|string',
            'option_c'        => 'required|string',
            'option_d'        => 'required|string',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        QuizQuestion::create($data);

        return redirect()
            ->route('quiz-questions.index')
            ->with('success', 'Question added successfully');
    }


    public function edit(QuizQuestion $quiz_question)
    {
        return view('admin.quiz.edit', compact('quiz_question'));
    }

    public function update(Request $request, QuizQuestion $quiz_question)
    {
        $data = $request->validate([
            'question'        => 'required|string',
            'option_a'        => 'required|string',
            'option_b'        => 'required|string',
            'option_c'        => 'required|string',
            'option_d'        => 'required|string',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        $quiz_question->update($data);

        return redirect()
            ->route('quiz-questions.index')
            ->with('success', 'Question updated');
    }

    public function toggle(QuizQuestion $quiz_question)
    {
        $quiz_question->update([
            'is_active' => ! $quiz_question->is_active
        ]);

        return back()->with('success', 'Question status updated');
    }
}
