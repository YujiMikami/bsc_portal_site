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
        
        // データをViewに渡す場合は
        // return view('my-page', ['data' => $data, 'id' => $id]);や
        // return view('my-page', compact('data', 'id'));
        // のようにします
        
        // ビューファイルがサブディレクトリにある場合、ドット(.)で区切って指定します。
        // 例: resources/views/admin/users/index.blade.php を表示する場合
        // return view('admin.users.index'); // <-- サブディレクトリの例
    }
}
