<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EditorController;
<<<<<<< HEAD
use App\Http\Controllers\RecipeController;
=======
use App\Http\Controllers\RecipesController;
>>>>>>> a24e37dd3d406fe5508eb4df9f38ed4c90021266

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//masuk halaman utama
Route::get('/', function () {
    return view('home.home');
})->name('home');

// Menampilkan halaman home dengan modal login
Route::get('/login', [LoginController::class, 'login'])->name('login');

// Menangani autentikasi login
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// Dashboard Admin
Route::get('/admin/dashboard', function () {
    return view('dashboard.admin.admin');
})->middleware(['auth', 'admin'])->name('admin.dashboard');

//untuk logout 
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Kelola Editor
Route::get('/admin/editors', [AdminController::class, 'editors'])->middleware(['auth', 'admin'])->name('admin.editors');
Route::post('/admin/editors', [AdminController::class, 'storeEditor'])->middleware(['auth', 'admin'])->name('admin.editors.store');
Route::patch('/admin/editors/{id}/toggle', [AdminController::class, 'toggleStatus'])->middleware(['auth', 'admin'])->name('admin.editors.toggle');
Route::delete('/admin/editors/{id}', [AdminController::class, 'deleteEditor'])->middleware(['auth', 'admin'])->name('admin.editors.delete');

//untuk mengelola member
Route::get('/admin/members', [AdminController::class, 'members'])->name('admin.members');
Route::patch('/admin/members/{id}/toggle', [AdminController::class, 'toggleStatus'])->name('admin.members.toggle');
Route::delete('/admin/members/{id}', [AdminController::class, 'deleteMember'])->middleware(['auth', 'admin'])->name('admin.members.delete');

//login editor
Route::get('/editor/dashboard', function () {
    return view('dashboard.editor.editor');
})->middleware(['auth', 'editor'])->name('editor.dashboard');

//mengelola resep oleh editor
Route::get('/editor/recipes', [EditorController::class, 'index'])->name('editor.recipes.index');
Route::patch('/editor/recipes/{id}/approve', [EditorController::class, 'approve'])->name('editor.recipes.approve');
Route::patch('/editor/recipes/{id}/decline', [EditorController::class, 'decline'])->name('editor.recipes.decline');
Route::delete('/editor/recipes/{id}', [EditorController::class, 'delete'])->name('editor.recipes.delete');

//untuk registrasi member
Route::post('/register', [LoginController::class, 'register'])->name('register.post');

<<<<<<< HEAD
=======
// Route untuk menampilkan form tambah resep
Route::get('/member/recipes/create', [RecipesController::class, 'create'])->name('member.recipes.create');
// Route untuk menyimpan resep
Route::post('/member/recipes', [RecipesController::class, 'store'])->name('member.recipes.store');
//menampilkan resep yang di buat member ke resepku
Route::get('/member/recipes', [RecipesController::class, 'index'])->name('member.recipes.index');
// Edit resep
Route::get('/member/recipes/{id}/edit', [RecipesController::class, 'edit'])->name('member.recipes.edit');
// Update resep
Route::put('/member/recipes/{id}', [RecipesController::class, 'update'])->name('member.recipes.update');






>>>>>>> a24e37dd3d406fe5508eb4df9f38ed4c90021266
