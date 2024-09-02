<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WriterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Writer\ArticleController as WriterArticleController;
use App\Http\Controllers\Writer\CategoryController as WriterCategoryController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\CommentController;
// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home'); 
/*
function () {

    return view('home');
})->name('home');*/
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');


Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/api/articles/{article}/comments', [CommentController::class, 'index'])->name('comments.index');
// Authentication routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');

// Profile routes
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/authors/{author}', [ProfileController::class, 'showAuthorProfile'])->name('author.profile');
// Admin routes with prefix and name
Route::middleware(['auth', 'writer'])->prefix('writer')->name('writer.')->group(function () {
    Route::get('/dashboard', [WriterController::class, 'index'])->name('dashboard');
    Route::resource('articles', WriterArticleController::class);
    Route::resource('categories', WriterCategoryController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/authors/{author}/follow', [FollowController::class, 'follow'])->name('authors.follow');
    Route::delete('/authors/{author}/unfollow', [FollowController::class, 'unfollow'])->name('authors.unfollow');
    Route::get('/follows', [FollowController::class, 'index'])->name('user.follows');
});

Route::post('/authors/{author}/subscribe', [SubscriptionController::class, 'subscribe'])->name('authors.subscribe');
Route::get('/authors/{author}/subscribe', [SubscriptionController::class, 'showPaymentPage'])->name('authors.subscribe.show');


Route::get('/test-storage', function () {
    try {
        Storage::disk('articles')->put('test.html', '<h1>Test</h1>');
        return 'File created successfully in ' . Storage::disk('articles')->path('test.html');
    } catch (\Exception $e) {
        return 'Failed to create file: ' . $e->getMessage();
    }
});