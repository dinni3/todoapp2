<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\MfaController;
use App\Http\Controllers\AdminController; // <-- admin controller (create later)

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;




// MFA routes should be public (not require auth)
Route::get('/mfa', [MfaController::class, 'show'])->name('mfa.show');
Route::post('/mfa', [MfaController::class, 'verify'])->name('mfa.verify');

Route::middleware(['auth'])->group(function () {

    // Routes for Normal User (To-Do CRUD)
    Route::middleware('role:user')->group(function () {
        Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
        Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
        Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
        Route::get('/todo/{todo}/edit', [TodoController::class, 'edit'])->name('todo.edit');
        Route::put('/todo/{todo}', [TodoController::class, 'update'])->name('todo.update');
        Route::delete('/todo/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy');
    });

    // Routes for Admin User
    Route::middleware('role:admin')->prefix('admin')->group(function () {
         Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/users/{user}/tasks', [AdminController::class, 'storeTask'])->name('admin.tasks.store');
        Route::get('/users', [AdminController::class, 'index'])->name('admin.users.index');
        Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/users/{user}/activate', [AdminController::class, 'activate'])->name('admin.users.activate');
        Route::post('/users/{user}/deactivate', [AdminController::class, 'deactivate'])->name('admin.users.deactivate');
     Route::patch('/users/{user}/activate', [AdminController::class, 'activate'])->name('admin.activate');
Route::patch('/users/{user}/deactivate', [AdminController::class, 'deactivate'])->name('admin.deactivate');
Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');

        // Add other admin routes here (user to-do list, permissions, etc.)
    });

    // Profile routes accessible to any logged-in user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
