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
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PaidRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SmartphoneLoanController;
use App\Http\Controllers\PcLoanController;
use App\Http\Controllers\TransportationExpensesController;
use App\Http\Controllers\InternalDocumentsController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/public/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //notification
    Route::get('/public/notification/{id}/show', [NotificationController::class, 'show'])->name('public.notification.show');

    //report
    Route::get('/public/reports', [ReportsController::class, 'index'])->name('public.reports.index');

    //paidrequest
    Route::get('/public/reports/paid-requests', [PaidRequestController::class, 'index'])->name('public.reports.paid-requests.index');
    Route::get('/public/reports/paid-rquests/create', [PaidRequestController::class, 'create'])->name('public.reports.paid-requests.create');
    Route::post('/public/reports/paid-requests/store', [PaidRequestController::class, 'store'])->name('public.reports.paid-requests.store');
    Route::put('/public/reports/paid-requests/{id}/update', [PaidRequestController::class, 'update'])->name('public.reports.paid-requests.update');
    Route::get('/public/reports/paid-requests/{id}/show', [PaidRequestController::class, 'show'])->name('public.reports.paid-requests.show');
    Route::get('/public/reports/paid-requests/{id}/edit', [PaidRequestController::class, 'edit'])->name('public.reports.paid-requests.edit');
    Route::delete('/public/reports/paid-rquests/{id}/delete', [PaidRequestController::class, 'destroy'])->name('public.reports.paid-requests.delete');
    Route::put('/public/reports/paid-requests/{id}/approval', [PaidRequestController::class, 'approval'])->name('public.reports.paid-requests.approval');
    Route::put('/public/reports/paid-requests/{id}/acceptance', [PaidRequestController::class, 'acceptance'])->name('public.reports.paid-requests.acceptance');

    //transportationexpenses
    Route::get('/public/reports/transportation-expenses', [TransportationExpensesController::class, 'index'])->name('public.reports.transportation-expenses.index');
    Route::get('/public/reports/transportation-expenses/create', [TransportationExpensesController::class, 'create'])->name('public.reports.transportation-expenses.create');
    Route::post('/public/reports/transportation-expenses/store', [TransportationExpensesController::class, 'store'])->name('public.reports.transportation-expenses.store');
    Route::put('/public/reports/transportation-expenses/{id}/{date}/update', [TransportationExpensesController::class, 'update'])->name('public.reports.transportation-expenses.update');
    Route::get('/public/reports/transportation-expenses/{id}/{date}/show', [TransportationExpensesController::class, 'show'])->name('public.reports.transportation-expenses.show');
    Route::get('/public/reports/transportation-expenses/{id}/{date}/edit', [TransportationExpensesController::class, 'edit'])->name('public.reports.transportation-expenses.edit');
    Route::delete('/public/reports/transportation-expenses/{id}/{date}/delete', [TransportationExpensesController::class, 'destroy'])->name('public.reports.transportation-expenses.delete');
    Route::put('/public/reports/transportation-expenses/{id}/{date}/approval', [TransportationExpensesController::class, 'approval'])->name('public.reports.transportation-expenses.approval');
    Route::put('/public/reports/transportation-expenses/{id}/{date}/acceptance', [TransportationExpensesController::class, 'acceptance'])->name('public.reports.transportation-expenses.acceptance');

    //safety
    Route::get('/public/reports/safety', [SafetyController::class, 'index'])->name('public.reports.safety.index');
    Route::get('/public/reports/safety/create', [SafetyController::class, 'create'])->name('public.reports.safety.create');
    Route::post('/public/reports/safety/store', [SafetyController::class, 'store'])->name('public.reports.safety.store');
    Route::delete('/public/reports/safety/{id}/delete', [SafetyController::class, 'destroy'])->name('public.reports.safety.delete');
    Route::put('/public/reports/safety/{id}/confirm', [SafetyController::class, 'confirm'])->name('public.reports.safety.confirm');

    // documents
    Route::get('/public/documents', [DocumentsController::class, 'index'])->name('public.documents.index');
    Route::get('/public/documents/create', [DocumentsController::class, 'create'])->name('public.documents.create');
    Route::post('/public/documents/store', [DocumentsController::class, 'store'])->name('public.documents.store');
    Route::get('/public/documents/{id}/edit', [DocumentsController::class, 'edit'])->name('public.documents.edit');
    Route::delete('/public/documents/{document}/delete', [DocumentsController::class, 'destroy'])->name('public.documents.delete');
    Route::put('/public/documents/{document}/update', [DocumentsController::class, 'update'])->name('public.documents.update');
    Route::get('/public/documents/{id}/view/', [DocumentsController::class, 'view'])->name('public.documents.view');






    Route::middleware('admin')->group(function () {

        //notification
        Route::get('/admin/notification', [NotificationController::class, 'index'])->name('admin.notification.index');
        Route::get('/admin/notification/create', [NotificationController::class, 'create'])->name('admin.notification.create');
        Route::get('/admin/notification/{id}/show', [NotificationController::class, 'show'])->name('admin.notification.show');
        Route::get('/admin/notification/{id}/edit', [NotificationController::class, 'edit'])->name('admin.notification.edit');
        Route::get('/admin/notification/{id}/unread', [NotificationController::class, 'unread'])->name('admin.notification.unread');
        Route::put('/admin/notification/{id}/update', [NotificationController::class, 'update'])->name('admin.notification.update');
        Route::delete('/admin/notification/{id}/delete', [NotificationController::class, 'destroy'])->name('admin.notification.delete');
        Route::post('/admin/notification/store', [NotificationController::class, 'store'])->name('admin.notification.store');

        //table
        Route::get('/admin/table', [TableController::class, 'index'])->name('admin.table.index');

        //employee
        Route::get('/admin/table/employees', [EmployeeController::class, 'index'])->name('admin.table.employees.index');
        Route::get('/admin/table/employees/create', [EmployeeController::class, 'create'])->name('admin.table.employees.create');
        Route::get('/admin/table/employees/{employee_id}/show', [EmployeeController::class, 'show'])->name('admin.table.employees.show');
        Route::get('/admin/table/employees/{employee_id}/edit', [EmployeeController::class, 'edit'])->name('admin.table.employees.edit');
        Route::put('/admin/table/employees/{employee_id}/update', [EmployeeController::class, 'update'])->name('admin.table.employees.update');
        Route::post('/admin/table/employees/store', [EmployeeController::class, 'store'])->name('admin.table.employees.store');
        Route::delete('/admin/table/employees/{employee_id}/delete', [EmployeeController::class, 'destroy'])->name('admin.table.employees.delete');
        Route::get('/admin/table/employees/exportcsv', [EmployeeController::class, 'exportcsv'])->name('admin.table.employees.exportcsv');
        Route::get('/admin/table/employees/importcsv', [EmployeeController::class, 'importcsv'])->name('admin.table.employees.importcsv');
        Route::post('/admin/table/employees/downloadcsv', [EmployeeController::class, 'downloadcsv'])->name('admin.table.employees.downloadcsv');
        Route::post('/admin/table/employees/uploadcsv', [EmployeeController::class, 'uploadcsv'])->name('admin.table.employees.uploadcsv');

        //department
        Route::get('/admin/table/departments', [DepartmentController::class, 'index'])->name('admin.table.departments.index');
        Route::get('/admin/table/departments/create', [DepartmentController::class, 'create'])->name('admin.table.departments.create');
        Route::get('/admin/table/departments/{department_id}/show', [DepartmentController::class, 'show'])->name('admin.table.departments.show');
        Route::get('/admin/table/departments/{department_id}/edit', [DepartmentController::class, 'edit'])->name('admin.table.departments.edit');
        Route::put('/admin/table/departments/{department_id}/update', [DepartmentController::class, 'update'])->name('admin.table.departments.update');
        Route::post('/admin/table/departments/store', [DepartmentController::class, 'store'])->name('admin.table.departments.store');
        Route::delete('/admin/table/departments/{department_id}/delete', [DepartmentController::class, 'destroy'])->name('admin.table.departments.delete');
        Route::get('/admin/table/departments/importcsv', [DepartmentController::class, 'importcsv'])->name('admin.table.departments.importcsv');
        Route::post('/admin/table/departments/uploadcsv', [DepartmentController::class, 'uploadcsv'])->name('admin.table.departments.uploadcsv');

        //occupation
        Route::get('/admin/table/occupations', [OccupationController::class, 'index'])->name('admin.table.occupations.index');
        Route::get('/admin/table/occupations/create', [OccupationController::class, 'create'])->name('admin.table.occupations.create');
        Route::get('/admin/table/occupations/{occupation_id}/show', [OccupationController::class, 'show'])->name('admin.table.occupations.show');
        Route::get('/admin/table/occupations/{occupation_id}/edit', [OccupationController::class, 'edit'])->name('admin.table.occupations.edit');
        Route::put('/admin/table/occupations/{occupation_id}/update', [OccupationController::class, 'update'])->name('admin.table.occupations.update');
        Route::post('/admin/table/occupations/store', [OccupationController::class, 'store'])->name('admin.table.occupations.store');
        Route::delete('/admin/table/occupations/{occupation_id}/delete', [OccupationController::class, 'destroy'])->name('admin.table.occupations.delete');
        Route::get('/admin/table/occupations/importcsv', [OccupationController::class, 'importcsv'])->name('admin.table.occupations.importcsv');
        Route::post('/admin/table/occupations/uploadcsv', [OccupationController::class, 'uploadcsv'])->name('admin.table.occupations.uploadcsv');

        //affiliation
        Route::get('/admin/table/affiliations', [AffiliationController::class, 'index'])->name('admin.table.affiliations.index');
        Route::get('/admin/table/affiliations/create', [AffiliationController::class, 'create'])->name('admin.table.affiliations.create');
        Route::get('/admin/table/affiliations/{affiliation_id}/show', [AffiliationController::class, 'show'])->name('admin.table.affiliations.show');
        Route::get('/admin/table/affiliations/{affiliation_id}/edit', [AffiliationController::class, 'edit'])->name('admin.table.affiliations.edit');
        Route::put('/admin/table/affiliations/{affiliation_id}/update', [AffiliationController::class, 'update'])->name('admin.table.affiliations.update');
        Route::post('/admin/table/affiliations/store', [AffiliationController::class, 'store'])->name('admin.table.affiliations.store');
        Route::delete('/admin/table/affiliations/{affiliation_id}/delete', [AffiliationController::class, 'destroy'])->name('admin.table.affiliations.delete');
        Route::get('/admin/table/affiliations/importcsv', [AffiliationController::class, 'importcsv'])->name('admin.table.affiliations.importcsv');
        Route::post('/admin/table/affiliations/uploadcsv', [AffiliationController::class, 'uploadcsv'])->name('admin.table.affiliations.uploadcsv');

        //employee-post
        Route::get('/admin/table/employee_posts', [EmployeePostController::class, 'index'])->name('admin.table.employee-posts.index');
        Route::get('/admin/table/employee_posts/create', [EmployeePostController::class, 'create'])->name('admin.table.employee-posts.create');
        Route::get('/admin/table/employee_posts/{employee_post_id}/show', [EmployeePostController::class, 'show'])->name('admin.table.employee-posts.show');
        Route::get('/admin/table/employee_posts/{employee_post_id}/edit', [EmployeePostController::class, 'edit'])->name('admin.table.employee-posts.edit');
        Route::put('/admin/table/employee_posts/{employee_post_id}/update', [EmployeePostController::class, 'update'])->name('admin.table.employee-posts.update');
        Route::post('/admin/table/employee_posts/store', [EmployeePostController::class, 'store'])->name('admin.table.employee-posts.store');
        Route::delete('/admin/table/employee_posts/{employee_post_id}/delete', [EmployeePostController::class, 'destroy'])->name('admin.table.employee-posts.delete');
        Route::get('/admin/table/employee_posts/importcsv', [EmployeePostController::class, 'importcsv'])->name('admin.table.employee-posts.importcsv');
        Route::post('/admin/table/employee_posts/uploadcsv', [EmployeePostController::class, 'uploadcsv'])->name('admin.table.employee-posts.uploadcsv');

        //employee_class
        Route::get('/admin/table/employee_classes', [EmployeeClassController::class, 'index'])->name('admin.table.employee-classes.index');
        Route::get('/admin/table/employee_classes/create', [EmployeeClassController::class, 'create'])->name('admin.table.employee-classes.create');
        Route::get('/admin/table/employee_classes/{employee_class_id}/show', [EmployeeClassController::class, 'show'])->name('admin.table.employee-classes.show');
        Route::get('/admin/table/employee_classes/{employee_class_id}/edit', [EmployeeClassController::class, 'edit'])->name('admin.table.employee-classes.edit');
        Route::put('/admin/table/employee_classes/{employee_class_id}/update', [EmployeeClassController::class, 'update'])->name('admin.table.employee-classes.update');
        Route::post('/admin/table/employee_classes/store', [EmployeeClassController::class, 'store'])->name('admin.table.employee-classes.store');
        Route::delete('/admin/table/employee_classes/{employee_class_id}/delete', [EmployeeClassController::class, 'destroy'])->name('admin.table.employee-classes.delete');
        Route::get('/admin/table/employee_classes/importcsv', [EmployeeClassController::class, 'importcsv'])->name('admin.table.employee-classes.importcsv');
        Route::post('/admin/table/employee_classes/uploadcsv', [EmployeeClassController::class, 'uploadcsv'])->name('admin.table.employee-classes.uploadcsv');

        //smartphone_loan
        Route::get('/admin/table/smartphone_loans', [SmartphoneLoanController::class, 'index'])->name('admin.table.smartphone-loans.index');
        Route::get('/admin/table/smartphone_loans/create', [SmartphoneLoanController::class, 'create'])->name('admin.table.smartphone-loans.create');
        Route::get('/admin/table/smartphone_loans/{id}/show', [SmartphoneLoanController::class, 'show'])->name('admin.table.smartphone-loans.show');
        Route::get('/admin/table/smartphone_loans/{id}/edit', [SmartphoneLoanController::class, 'edit'])->name('admin.table.smartphone-loans.edit');
        Route::put('/admin/table/smartphone_loans/{id}/update', [SmartphoneLoanController::class, 'update'])->name('admin.table.smartphone-loans.update');
        Route::post('/admin/table/smartphone_loans/store', [SmartphoneLoanController::class, 'store'])->name('admin.table.smartphone-loans.store');
        Route::delete('/admin/table/smartphone_loans/{id}/delete', [SmartphoneLoanController::class, 'destroy'])->name('admin.table.smartphone-loans.delete');

        //pc_loan
        Route::get('/admin/table/pc_loans', [PcLoanController::class, 'index'])->name('admin.table.pc-loans.index');
        Route::get('/admin/table/pc_loans/create', [PcLoanController::class, 'create'])->name('admin.table.pc-loans.create');
        Route::get('/admin/table/pc_loans/{id}/show', [PcLoanController::class, 'show'])->name('admin.table.pc-loans.show');
        Route::get('/admin/table/pc_loans/{id}/edit', [PcLoanController::class, 'edit'])->name('admin.table.pc-loans.edit');
        Route::put('/admin/table/pc_loans/{id}/update', [PcLoanController::class, 'update'])->name('admin.table.pc-loans.update');
        Route::post('/admin/table/pc_loans/store', [PcLoanController::class, 'store'])->name('admin.table.pc-loans.store');
        Route::delete('/admin/table/pc_loans/{id}/delete', [PcLoanController::class, 'destroy'])->name('admin.table.pc-loans.delete');

        Route::get('/admin/system', [SystemController::class, 'index'])->name('admin.system.index');

        //log
        Route::get('/admin/system/log', [LogController::class, 'index'])->name('admin.system.log.index');
    });
});
require __DIR__ . '/auth.php';
