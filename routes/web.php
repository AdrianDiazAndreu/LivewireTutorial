<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;

Route::redirect('/', '/dashboard');

Route::get('dashboard', function () {
    return view('dashboard', [Dashboard::class, "index"]); // Change this line
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('register', function () {
    return view('auth.register');
})->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tareas/{id}', [TaskController::class, 'show'])->name('tasks.show');


require __DIR__.'/auth.php';
