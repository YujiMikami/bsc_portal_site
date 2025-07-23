<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SafetyController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AffiliationController;
use App\Http\Controllers\EmployeePostController;
use App\Http\Controllers\EmployeeClassController;
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

    Route::get('/public/reports', [ReportsController::class, 'index'])->name('public.reports.index');
    Route::get('/public/reports/safety', [SafetyController::class, 'index'])->name('public.reports.safety.index');
    Route::get('/public/reports/safety/create', [SafetyController::class, 'create'])->name('public.reports.safety.create');
    Route::post('/public/reports/safety/store', [SafetyController::class, 'store'])->name('public.reports.safety.store');
    Route::delete('/public/reports/safety/{id}/delete', [SafetyController::class, 'destroy'])->name('public.reports.safety.delete');

        Route::middleware('admin')->group(function () {
            Route::get('/admin/table', [TableController::class, 'index'])->name('admin.table.index');
            
            Route::get('/admin/table/employees', [EmployeeController::class, 'index'])->name('admin.table.employees.index');
            Route::get('/admin/table/departments', [DepartmentController::class, 'index'])->name('admin.table.departments.index');
            Route::get('/admin/table/affiliations', [AffiliationController::class, 'index'])->name('admin.table.affiliations.index');
            Route::get('/admin/table/employee_posts', [EmployeePostController::class, 'index'])->name('admin.table.employee_posts.index');
            Route::get('/admin/table/employee_classes', [EmployeeClassController::class, 'index'])->name('admin.table.employee_classes.index');
            
            
            
            
            
            Route::get('/admin/employees/create', [EmployeeController::class, 'create'])->name('admin.table.employees.create');
            Route::get('/admin/employees/{id}/show', [EmployeeController::class, 'show'])->name('admin.table.employees.show');
            Route::get('/admin/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('admin.table.employees.edit');
            Route::put('/admin/employees/{id}/update', [EmployeeController::class, 'update'])->name('admin.table.employees.update');
            Route::post('/admin/employees/store', [EmployeeController::class, 'store'])->name('admin.table.employees.store');
            Route::delete('/admin/employees/{id}/delete', [EmployeeController::class, 'destroy'])->name('admin.table.employees.delete');
            Route::post('/admin/employees/configcsv', [EmployeeController::class, 'configcsv'])->name('admin.table.employees.configcsv');
            Route::get('/admin/employees/downloadcsv', [EmployeeController::class, 'downloadcsv'])->name('admin.table.employees.downloadcsv');
        });
    });
require __DIR__.'/auth.php';
