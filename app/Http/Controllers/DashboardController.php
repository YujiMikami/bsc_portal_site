<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaidRequest;
use App\Models\Safety;
use App\Models\Notification;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $message = [];
        if (Auth::user()->portal_role == 1) {
            $countPaidRequest = PaidRequest::where('affiliation', Auth::user()->affiliation_id)
            ->whereNull('approver')
            ->count();
            $countSafety = Safety::where('affiliation', Auth::user()->affiliation_id)
            ->whereNull('confirmer')
            ->count();
        
            if ($countPaidRequest !== 0) {
                $message[]='有給申請が' . $countPaidRequest . '件来ています';
            }
            if ($countSafety !== 0) {
                $message[]='安否報告が' . $countSafety . '件来ています';
            }
        }

        $user = Auth::user();
        $now = now();

        // 条件付きで通知を取得（start_at / end_at を考慮）
        $notifications = Notification::where(function ($q) use ($now) {
            $q->whereNull('start_at')->orWhere('start_at', '<=', $now);
        })
        ->where(function ($q) use ($now) {
            $q->whereNull('end_at')->orWhere('end_at', '>=', $now);
        })
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
        // 既読情報を後からロード
        // employeesの部分はリレーション先のテーブル名
        // employee_account_idの部分は中間テーブルのカラム名
        // $user->employee_idの部分は中間テーブルとの一致条件
        $notifications = Notification::with(['employees' => function($q) use ($user) {
            $q->where('employee_account_id', $user->employee_id);
        }])->get();
        return view('public.dashboard.index', compact('message', 'notifications'));
    }

}
