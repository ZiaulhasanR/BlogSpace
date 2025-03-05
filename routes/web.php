<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\PostEditController;
use App\Http\Controllers\UploadController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::post('/posts/{id}/like', [PostController::class, 'toggleLike'])->middleware('auth');


Route::middleware(['auth'])->group(function () {


    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->name('posts.comments.store');

    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');


    Route::middleware(['auth', 'author'])->group(function () {
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('create/post', [PostController::class, 'create'])->name('create.post');

        Route::post('/upload-image', [UploadController::class, 'uploadImage'])->name('upload.image');

        route::middleware(['is_post_owner'])->group(function () {
            Route::get('/posts/{post}/edit', [PostEditController::class, 'edit'])->name('posts.edit');
            Route::delete('/posts/{post}', [PostEditController::class, 'destroy'])->name('posts.destroy');


            Route::put('/posts/{post}', [PostEditController::class, 'update'])->name('posts.update');
        });
    });


    // Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{post}', [CommentController::class, 'store'])->name('comments.store');


    Route::middleware('auth', 'admin')->group(function () {
        Route::get('/admin/home', function () {
            return view('admin.home');
        })->name('admin.home');

        Route::get('/admin/users', [AdminUserController::class, 'index'])->name('users.index');
        //Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');

        // Update the user information
        Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');

        Route::get('/admin/posts', [AdminPostController::class, 'index'])->name('admin.posts.index');
        Route::get('/admin/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
        Route::delete('/admin/posts/{post}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');

        Route::put('/admin/posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
    });
});
