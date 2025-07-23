<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AffiliationController extends Controller
{
    public function index()
    {
        return view('admin.table.affiliations.index');
    }
}
