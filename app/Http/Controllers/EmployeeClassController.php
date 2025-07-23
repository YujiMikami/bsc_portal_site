<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeClassController extends Controller
{
    public function index()
    {
        return view('admin.table.employee-class.index');
    }
}
