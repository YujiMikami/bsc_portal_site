<?php

namespace App\Policies;

use App\Models\EmployeeAccount;
use App\Models\Safety;

class SafetyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function confirm(EmployeeAccount $employeeAccount): bool
    {
        return $employeeAccount->portal_role === 1;
    }
}
