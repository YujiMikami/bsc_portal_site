<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use App\Models\Employee;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create(
        [
            'employee_id' => '110021',
            'employee_name' => '三上　裕司',
            'gender' => '1',
            'employee_class_id' => '1',
            'hire_date' => date('Y-m-d H:i:s'),
            'updated_by' => '三上　裕司',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
