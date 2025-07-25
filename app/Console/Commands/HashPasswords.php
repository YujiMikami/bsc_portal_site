<?php

namespace app\Console\Commands;

use Illuminate\Console\Command;
use app\Models\Employee;
use Illuminate\Support\Facades\Hash;

class HashPasswords extends Command
{
    protected $signature = 'employees:hash-passwords';
    protected $description = '既存の平文パスワードをハッシュ化する';

    public function handle()
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            if (strlen($employee->password) !== 60 || !str_starts_with($employee->password, '$2')) {
                $employee->password = Hash::make($employee->password);
                $employee->save();
                $this->info("ハッシュ化: {$employee->employee_id}");
            }
        }

        $this->info('すべてのパスワードをハッシュ化しました。');
    }
}
