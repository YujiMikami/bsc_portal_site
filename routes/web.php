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
            
            //index
            Route::get('/admin/table/employees', [EmployeeController::class, 'index'])->name('admin.table.employees.index');
            Route::get('/admin/table/departments', [DepartmentController::class, 'index'])->name('admin.table.departments.index');
            Route::get('/admin/table/affiliations', [AffiliationController::class, 'index'])->name('admin.table.affiliations.index');
            Route::get('/admin/table/employee_posts', [EmployeePostController::class, 'index'])->name('admin.table.employee-posts.index');
            Route::get('/admin/table/employee_classes', [EmployeeClassController::class, 'index'])->name('admin.table.employee-classes.index');
            
            //create
            Route::get('/admin/table/employees/create', [EmployeeController::class, 'create'])->name('admin.table.employees.create');
            Route::get('/admin/table/departments/create', [DepartmentController::class, 'create'])->name('admin.table.departments.create');
            Route::get('/admin/table/affiliations/create', [AffiliationController::class, 'create'])->name('admin.table.affiliations.create');
            Route::get('/admin/table/employee_posts/create', [EmployeePostController::class, 'create'])->name('admin.table.employee-posts.create');
            Route::get('/admin/table/employee_classes/create', [EmployeeClassController::class, 'create'])->name('admin.table.employee-classes.create');

            //show
            Route::get('/admin/table/employees/{employee_id}/show', [EmployeeController::class, 'show'])->name('admin.table.employees.show');
            Route::get('/admin/table/departments/{department_id}/show', [DepartmentController::class, 'show'])->name('admin.table.departments.show');
            Route::get('/admin/table/affiliations/{affiliation_id}/show', [AffiliationController::class, 'show'])->name('admin.table.affiliations.show');
            Route::get('/admin/table/employee_posts/{employee_post_id}/show', [EmployeePostController::class, 'show'])->name('admin.table.employee-posts.show');
            Route::get('/admin/table/employee_classes/{employee_class_id}/show', [EmployeeClassController::class, 'show'])->name('admin.table.employee-classes.show');

            //edit
            Route::get('/admin/table/employees/{employee_id}/edit', [EmployeeController::class, 'edit'])->name('admin.table.employees.edit');
            Route::get('/admin/table/departments/{department_id}/edit', [DepartmentController::class, 'edit'])->name('admin.table.departments.edit');
            Route::get('/admin/table/affiliations/{affiliation_id}/edit', [AffiliationController::class, 'edit'])->name('admin.table.affiliations.edit');
            Route::get('/admin/table/employee_posts/{employee_post_id}/edit', [EmployeePostController::class, 'edit'])->name('admin.table.employee-posts.edit');
            Route::get('/admin/table/employee_classes/{employee_class_id}/edit', [EmployeeClassController::class, 'edit'])->name('admin.table.employee-classes.edit');

            //update
            Route::put('/admin/table/employees/{employee_id}/update', [EmployeeController::class, 'update'])->name('admin.table.employees.update');
            Route::put('/admin/table/departments/{department_id}/update', [DepartmentController::class, 'update'])->name('admin.table.departments.update');
            Route::put('/admin/table/affiliations/{affiliation_id}/update', [AffiliationController::class, 'update'])->name('admin.table.affiliations.update');
            Route::put('/admin/table/employee_posts/{employee_post_id}/update', [EmployeePostController::class, 'update'])->name('admin.table.employee-posts.update');
            Route::put('/admin/table/employee_classes/{employee_class_id}/update', [EmployeeClassController::class, 'update'])->name('admin.table.employee-classes.update');

            //store
            Route::post('/admin/table/employees/store', [EmployeeController::class, 'store'])->name('admin.table.employees.store');
            Route::post('/admin/table/departments/store', [DepartmentController::class, 'store'])->name('admin.table.departments.store');
            Route::post('/admin/table/affiliations/store', [AffiliationController::class, 'store'])->name('admin.table.affiliations.store');
            Route::post('/admin/table/employee_posts/store', [EmployeePostController::class, 'store'])->name('admin.table.employee-posts.store');
            Route::post('/admin/table/employee_classes/store', [EmployeeClassController::class, 'store'])->name('admin.table.employee-classes.store');

            //destroy
            Route::delete('/admin/table/employees/{employee_id}/delete', [EmployeeController::class, 'destroy'])->name('admin.table.employees.delete');
            Route::delete('/admin/table/departments/{department_id}/delete', [DepartmentController::class, 'destroy'])->name('admin.table.departments.delete');
            Route::delete('/admin/table/affiliations/{affiliation_id}/delete', [AffiliationController::class, 'destroy'])->name('admin.table.affiliations.delete');
            Route::delete('/admin/table/employee_posts/{employee_post_id}/delete', [EmployeePostController::class, 'destroy'])->name('admin.table.employee-posts.delete');
            Route::delete('/admin/table/employee_classes/{employee_class_id}/delete', [EmployeeClassController::class, 'destroy'])->name('admin.table.employee-classes.delete');
            
            //csv            
            Route::post('/admin/table/employees/configcsv', [EmployeeController::class, 'configcsv'])->name('admin.table.employees.configcsv');
            Route::get('/admin/table/employees/downloadcsv', [EmployeeController::class, 'downloadcsv'])->name('admin.table.employees.downloadcsv');
        });
    });
require __DIR__.'/auth.php';
