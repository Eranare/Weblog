<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
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

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');


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

// Admin routes with prefix and name
Route::middleware(['auth', 'writer'])->prefix('writer')->name('writer.')->group(function () {
    Route::get('/dashboard', [WriterController::class, 'index'])->name('dashboard');
    Route::resource('articles', WriterArticleController::class);
    Route::resource('categories', WriterCategoryController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/follow/{writer}', [FollowController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{writer}', [FollowController::class, 'unfollow'])->name('unfollow');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/subscribe/{writer}', [SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::post('/unsubscribe/{writer}', [SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');
});
