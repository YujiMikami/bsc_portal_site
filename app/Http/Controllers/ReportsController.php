<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\log;

class ReportsController extends Controller
{
    public function index()
    {
        return view('public.reports.index');
    }
}
