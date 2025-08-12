<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeAccount;
use Illuminate\Support\Facades\Hash;

class EmployeeAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeAccount::create(
        [
            'employee_id' => '110021',
            'employee_name' => '三上　裕司',
            'employee_name_furigana' => 'みかみ　ゆうじ',
            'employee_class_id' => '1',
            'department_id' => '1',
            'affiliation_id' => '1',
            'employee_post_id' => '1',
            'occupation_id' => '1',
            'email' => 'test@example.com', 
            'password' => Hash::make('bsc110021'),
            'portal_role' => '1',
        ]);
    }
}
