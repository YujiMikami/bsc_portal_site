<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaidRequest;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PaidRequestController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 1) {
            $paidRequests = PaidRequest::all();
        } else {
            $paidRequests = PaidRequest::where('employee_id', auth::user()->employee_id)->get();
        }
          
        return view('public.reports.paid-requests.index', compact('paidRequests'));
    }

    public function create()
    {
        return view('public.reports.paid-requests.create');
    }
    
    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validatePaidRequest($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // リダイレクト先を admin.tasks.create ルートに変更
            return redirect(route('public.reports.paid-requests.create')) 
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        // Taskモデルのカスタムメソッドを使ってデータを保存
        $paidRequest = new PaidRequest();
        // $request オブジェクトを直接 saveTask メソッドに渡す
        try {
            $paidRequest->savePaidRequest($request); 

        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // /admin/tasks にリダイレクトする（既に定義済みのタスク一覧ページなどへ）
        // 成功メッセージをセッションにフラッシュデータとして保存
        return redirect(route('public.reports.paid-requests.index'))->with('success', '有給申請が正常に登録されました。');
    }

    private function validatePaidRequest(Request $request)
    {
        $rules = [
            'application_date' => 'required',
            'employee_id' => 'required',
            'affiliation' => 'required',
            'employee_name' => 'required',
            'start_date' => 'required',
            'days' => 'required',
            'distinction' => 'required',
            'reason' => 'required',
        ];

        $messages = [
            'application_date.required' => ':attributeは必須項目です。',
            'employee_id.required' => ':attributeは必須項目です。',
            'affiliation.required' => ':attributeは必須項目です。',
            'employee_name.required' => ':attributeは必須項目です。',
            'start_date.required' => ':attributeは必須項目です。',
            'days.required' => ':attributeは必須項目です。',
            'distinction.required' => ':attributeは必須項目です。',
            'reason.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'application_date' => '申請日',
            'employee_id' => '申請者社員番号',
            'affiliation' => '所属',
            'employee_name' => '申請者名',
            'start_date' => '開始日',
            'days' => '日数',
            'distinction' => '区分',
            'reason' => '事由',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
}
