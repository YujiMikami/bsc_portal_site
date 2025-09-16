<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\log;
use App\Models\PaidRequest;
use App\Models\TransportationExpense;
use App\Models\Safety;

class ReportsController extends Controller
{
    public function index()
    {
        $paidRequests = PaidRequest::where('employee_id', auth::user()->employee_id)
            ->whereNull('recipient')
            ->get();

        $transportationExpenses = TransportationExpense::where('employee_id', auth::user()->employee_id)
            ->whereNull('approver')
            ->where('submitted', 1)
            ->get()
            ->groupBy('applied_date');
        return view('public.reports.index', compact(['paidRequests', 'transportationExpenses']));
    }
}
