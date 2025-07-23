<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SafetyController;
use App\Http\Controllers\ReportsController;
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

    Route::get('/user/reports', [ReportsController::class, 'index'])->name('user.reports.index');
    
    Route::get('/user/reports/safety', [SafetyController::class, 'index'])->name('user.reports.safety.index');
    Route::get('/user/reports/safety/create', [SafetyController::class, 'create'])->name('user.reports.safety.create');
    Route::post('/user/reports/safety/store', [SafetyController::class, 'store'])->name('user.reports.safety.store');
    Route::delete('/user/reports/safety/{id}/delete', [SafetyController::class, 'destroy'])->name('user.reports.safety.delete');

    Route::get('/admin/safeties', [SafetyController::class, 'index'])->name('admin.safeties.index');
    Route::get('/admin/reports/safeties/create', [SafetyController::class, 'create'])->name('admin.safeties.create');
    Route::post('/admin/reports/safeties/store', [SafetyController::class, 'store'])->name('usadminer.safeties.store');



    Route::get('/admin/employees', [EmployeeController::class, 'index'])->name('admin.employees.index');
    Route::get('/admin/employees/create', [EmployeeController::class, 'create'])->name('admin.employees.create');
    Route::get('/admin/employees/{id}/show', [EmployeeController::class, 'show'])->name('admin.employees.show');
    Route::get('/admin/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('admin.employees.edit');
    Route::put('/admin/employees/{id}/update', [EmployeeController::class, 'update'])->name('admin.employees.update');
    Route::post('/admin/employees/store', [EmployeeController::class, 'store'])->name('admin.employees.store');
    Route::delete('/admin/employees/{id}/delete', [EmployeeController::class, 'destroy'])->name('admin.employees.delete');
    Route::post('/admin/employees/configcsv', [EmployeeController::class, 'configcsv'])->name('admin.employees.configcsv');
    Route::get('/admin/employees/downloadcsv', [EmployeeController::class, 'downloadcsv'])->name('admin.employees.downloadcsv');
});

require __DIR__.'/auth.php';
