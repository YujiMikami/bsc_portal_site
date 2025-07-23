<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeePostController extends Controller
{
    public function index()
    {
        return view('admin.table.employee-posts.index');
    }
}
