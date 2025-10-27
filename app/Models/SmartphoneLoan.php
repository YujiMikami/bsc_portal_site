<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmartphoneLoan extends Model
{
    protected $fillable = [
        'phone_number',
        'employee_id',
        'employee_name',
        'department_1',
        'department_2',
        'affiliation',
        'email',
        'loan_start_at',
        'loan_end_at',
        'model',
        'guarantee',
        'updated_by',
    ];

    protected $casts = [];

    public function saveSmartphoneLoan(Request $request)
    {
        $this->phone_number = $request->input('phone_number');
        $this->employee_id = $request->input('employee_id');
        $this->employee_name = $request->input('employee_name');
        $this->department_1 = $request->input('department_1');
        $this->department_2 = $request->input('department_2');
        $this->affiliation = $request->input('affiliation');
        $this->email = $request->input('email');
        $this->loan_start_at = $request->input('loan_start_at');
        $this->loan_end_at = $request->input('loan_end_at');
        $this->model = $request->input('model');
        $this->guarantee = $request->input('guarantee');
        $this->updated_by = Auth::user()->employee_name;
        $this->save();
    }
}
