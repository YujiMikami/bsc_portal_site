<?php

namespace App\Policies;

use App\Models\EmployeeAccount;
use App\Models\PaidRequest;
use Illuminate\Auth\Access\Response;
class PaidRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(EmployeeAccount $employeeAccount): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(EmployeeAccount $employeeAccount, PaidRequest $paidRequest): bool
    {
        return $employeeAccount->employee_id === $paidRequest->employee_id && $paidRequest->approver === NULL;
// ここ修正
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(EmployeeAccount $employeeAccount): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(EmployeeAccount $employeeAccount, PaidRequest $paidRequest)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(EmployeeAccount $employeeAccount, PaidRequest $paidRequest): bool
    {
        return $employeeAccount->employee_id === $paidRequest->employee_id && $paidRequest->approver === NULL;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(EmployeeAccount $employeeAccount, PaidRequest $paidRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(EmployeeAccount $employeeAccount, PaidRequest $paidRequest): bool
    {
        return false;
    }

    public function approval(EmployeeAccount $employeeAccount): bool
    {
        return $employeeAccount->employee_post_id === 4;
    }

    public function acceptance(EmployeeAccount $employeeAccount): bool
    {
        return $employeeAccount->portal_role === 1;
    }

}
