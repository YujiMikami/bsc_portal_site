<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SafetyController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;
use app\Http\Middleware\RoleCheck;
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

    Route::get('/public/reports', [ReportsController::class, 'index'])->name('public.reports.index');
    Route::get('/public/reports/safety', [SafetyController::class, 'index'])->name('public.reports.safety.index');
    Route::get('/public/reports/safety/create', [SafetyController::class, 'create'])->name('public.reports.safety.create');
    Route::post('/public/reports/safety/store', [SafetyController::class, 'store'])->name('public.reports.safety.store');
    Route::delete('/public/reports/safety/{id}/delete', [SafetyController::class, 'destroy'])->name('public.reports.safety.delete');

        Route::middleware('admin')->group(function () {
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
    });
require __DIR__.'/auth.php';
