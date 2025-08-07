<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\PaidRequest;
use Illuminate\Auth\Access\Response;
class PaidRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Employee $employee): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Employee $employee, PaidRequest $paidRequest): bool
    {
        return $employee->employee_id === $paidRequest->employee_id;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Employee $employee): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Employee $employee, PaidRequest $paidRequest)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Employee $employee, PaidRequest $paidRequest): bool
    {
        return $employee->employee_id === $paidRequest->employee_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Employee $employee, PaidRequest $paidRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Employee $employee, PaidRequest $paidRequest): bool
    {
        return false;
    }

    public function approval(Employee $employee): bool
    {
        return $employee->portal_role === 1;
    }

    public function acceptance(Employee $employee): bool
    {
        return $employee->department_id	 === 4;
    }

}
