<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TableHistory;

class TableController extends Controller
{
    public function index()
    {
        $tableHistories = TableHistory::orderBy('history_id', 'desc')->get();
        
        return view('admin.table.index', compact('tableHistories'));
    }
}
