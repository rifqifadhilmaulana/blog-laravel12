<?php
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;gi
// Import Admin Controllers
use App\Http\Controllers\Admin\AdminController; 
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController; 

// Artikel global (bisa dilihat semua orang, tidak butuh login)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/', function () {
    return redirect()->route('posts.index');
});
 


// Auth
Route::middleware('guest')->group(function () {
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register-proses', [LoginController::class, 'register_proses'])->name('register-proses');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Artikel saya (MyPost) — butuh login
Route::middleware('auth')->group(function () {
    Route::get('/mypost', [PostController::class, 'myPosts'])->name('myposts');
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/mypost', [PostController::class, 'store'])->name('posts.store');
    Route::get('/mypost/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/mypost/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/mypost/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/profile', [ProfileController::class, 'myProfile'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/follow/{user:username}/toggle', [FollowController::class, 'toggle'])->name('follow.toggle');
    Route::get('/profile/{user:username}', [ProfileController::class, 'show'])->name('profile.user');
    Route::get('/profile/{user:username}/following', [FollowController::class, 'following'])->name('user.following');
    Route::get('/profile/{user:username}/followers', [FollowController::class, 'followers'])->name('user.followers');
    Route::post('/posts/{post}/favorite', [FavoriteController::class, 'toggle'])->name('posts.favorite');
    Route::get('/myfavorite', [FavoriteController::class, 'favorite'])->name('my.favorites');
    Route::post('/posts/{post:slug}/comments', [CommentController::class, 'komen'])->name('comments.store');
    // Menggunakan {comment} untuk menghapus komentar spesifik
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
   
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::patch('/comments/{id}/hide', [CommentController::class, 'hide'])->name('comments.hide');
    Route::patch('/comments/{id}/unhide', [CommentController::class, 'unhide'])->name('comments.unhide');

});

// ADMIN ROUTES (Dilindungi oleh 'auth' dan 'admin' middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard Admin
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // Manajemen Kategori (CRUD resource)
    Route::resource('categories', AdminCategoryController::class)
         ->except(['show'])
         ->names('admin.categories');
    
     // Kelola Pengguna (NEW)
    Route::resource('users', AdminUserController::class)
         ->only(['index', 'destroy'])
         ->names('admin.users');

    // Manajemen Semua Postingan Pengguna
    Route::get('posts', [AdminController::class, 'postsIndex'])->name('admin.posts.index');
    // Rute untuk Hapus Postingan siapapun
    Route::delete('posts/{post}', [AdminController::class, 'postsDestroy'])->name('admin.posts.destroy');
});