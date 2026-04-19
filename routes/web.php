<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuizManageController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

// Home → redirect to admin login
Route::get('/', function () {
    return redirect()->route('login');
});

// Language switcher
Route::post('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Public quiz routes
Route::get('/quiz/{slug}', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/quiz/{slug}/start', [QuizController::class, 'start'])->name('quiz.start');
Route::get('/quiz/{slug}/take', [QuizController::class, 'questions'])->name('quiz.take');
Route::post('/quiz/{slug}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
Route::get('/quiz/{slug}/result/{attempt}', [QuizController::class, 'result'])->name('quiz.result');

// Auth
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');

// Admin (auth protected)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('quizzes', QuizManageController::class);

    // Profile Management
    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

    // System Settings
    Route::get('settings', [\App\Http\Controllers\Admin\SystemSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [\App\Http\Controllers\Admin\SystemSettingController::class, 'update'])->name('settings.update');

    // Question management (nested)
    Route::post('quizzes/{quiz}/questions', [QuizManageController::class, 'storeQuestion'])->name('quizzes.questions.store');
    Route::get('quizzes/{quiz}/questions/{question}/edit', [QuizManageController::class, 'editQuestion'])->name('quizzes.questions.edit');
    Route::put('quizzes/{quiz}/questions/{question}', [QuizManageController::class, 'updateQuestion'])->name('quizzes.questions.update');
    Route::delete('quizzes/{quiz}/questions/{question}', [QuizManageController::class, 'destroyQuestion'])->name('quizzes.questions.destroy');
    
    // AI Question generation
    Route::post('quizzes/{quiz}/ai-generate', [\App\Http\Controllers\Admin\AiQuestionController::class, 'generate'])->name('quizzes.ai.generate');

    // Quiz Preview (admin only)
    Route::get('quizzes/{quiz}/preview', [QuizManageController::class, 'preview'])->name('quizzes.preview');

    // Results
    Route::get('results', [ResultController::class, 'index'])->name('results.index');
    Route::get('results/export/{quiz?}', [ResultController::class, 'export'])->name('results.export');
    Route::get('results/{attempt}', [ResultController::class, 'show'])->name('results.show');
    Route::post('results/{attempt}/grade/{answer}', [ResultController::class, 'updateGrade'])->name('results.grade');
    Route::delete('results/{attempt}', [ResultController::class, 'destroy'])->name('results.destroy');
});


