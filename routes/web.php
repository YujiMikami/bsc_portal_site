<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SafetyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/safety', [SafetyController::class, 'index'])->name('admin.safety.index');
    Route::get('/safety/create', [SafetyController::class, 'create'])->name('admin.safety.create');
    Route::post('/safety/store', [SafetyController::class, 'store'])->name('admin.safety.store');

    Route::get('/employee', [EmployeeController::class, 'index'])->name('admin.employee.index');

});

require __DIR__.'/auth.php';
