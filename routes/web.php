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

    Route::get('/admin/safety', [SafetyController::class, 'index'])->name('admin.safety.index');
    Route::get('/admin/safety/create', [SafetyController::class, 'create'])->name('admin.safety.create');
    Route::post('/admin/safety/store', [SafetyController::class, 'store'])->name('admin.safety.store');

    Route::get('/admin/employee', [EmployeeController::class, 'index'])->name('admin.employee.index');
    Route::get('/admin/employee/create', [EmployeeController::class, 'create'])->name('admin.employee.create');
    Route::get('/admin/employee/{id}/show', [EmployeeController::class, 'show'])->name('admin.employee.show');
    Route::get('/admin/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('admin.employee.edit');
    Route::put('/admin/employee/{id}/update', [EmployeeController::class, 'update'])->name('admin.employee.update');
    Route::post('/admin/employee/store', [EmployeeController::class, 'store'])->name('admin.employee.store');
    Route::delete('/admin/employee/{id}/delete', [EmployeeController::class, 'destroy'])->name('admin.employee.delete');
    Route::post('/admin/employee/configcsv', [EmployeeController::class, 'configcsv'])->name('admin.employee.configcsv');
    Route::get('/admin/employee/downloadcsv', [EmployeeController::class, 'downloadcsv'])->name('admin.employee.downloadcsv');
});

require __DIR__.'/auth.php';
