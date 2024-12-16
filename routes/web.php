<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\EditorRecipesController;

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
//untuk search resep pada home
Route::get('/search', [SearchController::class, 'search'])->name('home.search');
// Search pada Resepmu
Route::get('/member/recipes/search', [SearchController::class, 'searchUserRecipes'])->name('member.recipes.search');

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
// Search Editor di Admin
Route::get('/admin/editors/search', [SearchController::class, 'searchEditors'])->name('admin.editors.search');

//untuk mengelola member
Route::get('/admin/members', [AdminController::class, 'members'])->name('admin.members');
Route::patch('/admin/members/{id}/toggle', [AdminController::class, 'toggleStatus'])->name('admin.members.toggle');
Route::delete('/admin/members/{id}', [AdminController::class, 'deleteMember'])->middleware(['auth', 'admin'])->name('admin.members.delete');
//search member di admin
Route::get('/admin/members/search', [SearchController::class, 'searchMembers'])->name('admin.members.search');


//login editor
Route::get('/editor/dashboard', function () {
    return view('dashboard.editor.editor');
})->middleware(['auth', 'editor'])->name('editor.dashboard');

//mengelola resep oleh editor
Route::get('/editor/recipes', [EditorController::class, 'index'])->name('editor.recipes.index');
Route::patch('/editor/recipes/{id}/approve', [EditorController::class, 'approve'])->name('editor.recipes.approve');
Route::patch('/editor/recipes/{id}/decline', [EditorController::class, 'decline'])->name('editor.recipes.decline');
Route::delete('/editor/recipes/{id}', [EditorController::class, 'delete'])->name('editor.recipes.delete');
//search resep oleh editor
Route::get('/editor/recipes/search', [SearchController::class, 'searchEditorRecipes'])->name('editor.recipes.search');


//untuk registrasi member
Route::post('/register', [LoginController::class, 'register'])->name('register.post');

// Route untuk menampilkan form tambah resep
Route::get('/member/recipes/create', [RecipesController::class, 'create'])->name('member.recipes.create');
// Route untuk menyimpan resep
Route::post('/member/recipes', [RecipesController::class, 'store'])->name('member.recipes.store');
//menampilkan resep yang di buat member ke resepku
Route::get('/member/recipes', action: [RecipesController::class, 'index'])->name('member.recipes.index');
// Edit resep
Route::get('/member/recipes/{id}/edit', [RecipesController::class, 'edit'])->name('member.recipes.edit');
// Update resep
Route::put('/member/recipes/{id}', [RecipesController::class, 'update'])->name('member.recipes.update');
//menampilkan resep yang sudah di approve editor ke home
// Route::get('/home', [RecipesController::class, 'showApprovedRecipes'])->name('home');
Route::get('/', [RecipesController::class, 'home'])->name('home');

Route::get('/recipes/{id}', action: [RecipesController::class, 'show'])->name('recipes.show')->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.showprofile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


Route::get('/dashboard/editor/recipes/create', [RecipesController::class, 'createByEditor'])->name('editor.recipes.create');

// Rute untuk menyimpan resep yang diajukan oleh anggota (Editor bisa memilih statusnya)
Route::post('/dashboard/editor/recipes', [RecipesController::class, 'storeByEditor'])->name('editor.recipes.store');


// Route::get('/dashboard/editor/recipes/index', action: [RecipesController::class, 'indexEditor'])->name('dashboard.editor.recipes.index');

Route::get('/dashboard/editor/recipes/index', [EditorRecipesController::class, 'indexEditor'])->name('dashboard.editor.recipes.index');

// Route untuk halaman semua resep editor
Route::get('/recipes/showeditor', [RecipesController::class, 'showEditorRecipes'])->name('recipes.showeditor');
