<?php

namespace App\Policies;

use App\Models\EmployeeAccount;
use App\Models\TransportationExpense;
use Illuminate\Auth\Access\Response;

class TransportationExpensePolicy
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
    public function view(EmployeeAccount $employeeAccount, TransportationExpense $transportationExpense): bool
    {
        return $employeeAccount->employee_id === $transportationExpense->employee_id && $transportationExpense->approver === NULL;
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
    public function update(EmployeeAccount $employeeAccount, TransportationExpense $transportationExpense): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(EmployeeAccount $employeeAccount, TransportationExpense $transportationExpense): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(EmployeeAccount $employeeAccount, TransportationExpense $transportationExpense): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(EmployeeAccount $employeeAccount, TransportationExpense $transportationExpense): bool
    {
        return false;
    }

    public function approval(EmployeeAccount $employeeAccount, TransportationExpense $transportationExpense): bool
    {
        return $employeeAccount->employee_post_id === 4;
    }

    public function acceptance(EmployeeAccount $employeeAccount, TransportationExpense $transportationExpense): bool
    {
        return $employeeAccount->portal_role === 1;
    }

}
