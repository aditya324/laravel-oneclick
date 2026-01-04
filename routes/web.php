<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\QuizQuestionController;
use App\Http\Controllers\Admin\QuizAnalyticsController;

Route::get('/register', function () {
    return view('register');
});


Route::post('/register', [StudentRegistrationController::class, 'store'])
    ->name('student.register');

Route::get('/quiz/{student}', [QuizController::class, 'start'])
    ->name('quiz.start');

Route::post('/quiz/{student}/submit', [QuizController::class, 'submit'])
    ->name('quiz.submit');


Route::get('/payment/{student}', function () {
    return view('payment');
})->name('payment.page');

Route::middleware('admin', 'auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/students/{student}', [AdminDashboardController::class, 'show'])
        ->name('admin.students.show');

    Route::get('/quiz-questions', [QuizQuestionController::class, 'index'])
        ->name('quiz-questions.index');

    Route::get('/quiz-questions/create', [QuizQuestionController::class, 'create'])
        ->name('quiz-questions.create');

    Route::post('/quiz-questions', [QuizQuestionController::class, 'store'])
        ->name('quiz-questions.store');

    Route::get(
        '/quiz-questions/{quiz_question}/edit',
        [QuizQuestionController::class, 'edit']
    )->name('quiz-questions.edit');

    Route::put(
        '/quiz-questions/{quiz_question}',
        [QuizQuestionController::class, 'update']
    )->name('quiz-questions.update');

    Route::patch(
        '/quiz-questions/{quiz_question}/toggle',
        [QuizQuestionController::class, 'toggle']
    )->name('quiz-questions.toggle');

    Route::get(
        '/analytics/questions',
        [QuizAnalyticsController::class, 'questions']
    )
        ->name('admin.analytics.questions');
});


Route::get('/admin-login', function () {
    session(['is_admin' => true]);
    return redirect()->route('admin.dashboard');
});


Route::get('/admin-test', function () {
    return 'Admin middleware works';
})->middleware('admin');
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

require __DIR__ . '/auth.php';
