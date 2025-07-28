<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('departments')) {
            $departments = DB::table('departments')->pluck('department_name', 'department_id')->toArray();
            Config::set('departments', $departments);
        }
        if (Schema::hasTable('affiliations')) {
            $affiliations = DB::table('affiliations')->pluck('affiliation_name', 'affiliation_id')->toArray();
            Config::set('affiliations', $affiliations);
        }
        if (Schema::hasTable('employee_classes')) {
            $employeeClasses = DB::table('employee_classes')->pluck('employee_class_name', 'employee_class_id')->toArray();
            Config::set('employee_classes', $employeeClasses);
        }
        if (Schema::hasTable('employee_posts')) {
            $employeePosts = DB::table('employee_posts')->pluck('employee_post_name', 'employee_post_id')->toArray();
            Config::set('employee_posts', $employeePosts);
        }
        if (Schema::hasTable('occupations')) {
            $occupations = DB::table('occupations')->pluck('occupation_name', 'occupation_id')->toArray();
            Config::set('occupations', $occupations);
        }
    }
}
