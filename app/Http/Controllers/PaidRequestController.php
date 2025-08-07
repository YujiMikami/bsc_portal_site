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
        if (Auth::user()->portal_role == 1) {
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

        $paidRequest = new PaidRequest();
        try {
            $paidRequest->savePaidRequest($request); 

        } catch (Exception $e) {
            Log::channel('error')->alert('有給申請エラー(PaidRequestController->store)', [$e->getMessage()]);
            return redirect(route('public.reports.paid-requests.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('public.reports.paid-requests.index'))->with('success', '有給申請を正常に登録しました。');
    }

    public function show($id)
    {
        try {
            $paidRequest = PaidRequest::findOrFail($id);
        if ($paidRequest->employee_id !== Auth::user()->employee_id && Auth::user()->portal_role !== 1) {
            return redirect(route('public.reports.paid-requests.index'))->with('error', '他の申請は閲覧できません。');
        }

        } catch (Exception $e) {
            Log::channel('error')->alert('有給申請エラー(PaidRequestController->show)', [$e->getMessage()]);
            return redirect(route('public.reports.paid-requests.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return view('public.reports.paid-requests.show', compact('paidRequest'));
    }
    public function edit($id)
    {
        try {
            $paidRequest = PaidRequest::findOrFail($id);
        if ($paidRequest->employee_id !== Auth::user()->employee_id) {
            return redirect(route('public.reports.paid-requests.index'))->with('error', '他の申請は更新できません。');
        }
        } catch (Exception $e) {
            Log::channel('error')->alert('有給申請エラー(PaidRequestController->edit)', [$e->getMessage()]);
            return redirect(route('public.reports.paid-requests.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }
        return view('public.reports.paid-requests.create', compact('paidRequest'));
    }

    public function update(Request $request, $id)
    {
        // バリデーション
        $validator = $this->validatePaidRequest($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // 編集フォームのルートにリダイレクト
            return redirect(route('public.reports.paid-requests.edit', $id))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        try {
            $paidRequest = PaidRequest::findOrFail($id);
            $paidRequest->savePaidRequest($request);

        } catch (Exception $e) {
            Log::channel('error')->alert('有給申請エラー(PaidRequestController->update)', [$e->getMessage()]);
            return redirect(route('public.reports.paid-requests.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('public.reports.paid-requests.index'))->with('success', '有給申請を正常に更新しました。');
    }

    public function destroy($id)
    {
        try {
            $paidRequest = PaidRequest::findOrFail($id);

            $paidRequest->delete();

        } catch (Exception $e) {
            Log::channel('error')->alert('有給申請エラー(PaidRequestController->destroy)', [$e->getMessage()]);
            return redirect(route('public.reports.paid-requests.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('public.reports.paid-requests.index'))->with('success', '有給申請を削除しました。');
    }

    public function approval($id)
    {
        try {
            $paidRequest = PaidRequest::findOrFail($id);

            $paidRequest->approver = Auth::user()->employee_name;
            $paidRequest->save();
        
        } catch (Exception $e) {
            Log::channel('error')->alert('有給申請エラー(PaidRequestController->approval)', [$e->getMessage()]);
            return redirect(route('public.reports.paid-requests.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('public.reports.paid-requests.index'))->with('success', '有給申請を承認しました。');
    }

    public function acceptance($id)
    {
        try {
            $paidRequest = PaidRequest::findOrFail($id);

            $paidRequest->recipient = Auth::user()->employee_name;
            $paidRequest->save();
        
        } catch (Exception $e) {
            Log::channel('error')->alert('有給申請エラー(PaidRequestController->acceptance)', [$e->getMessage()]);
            return redirect(route('public.reports.paid-requests.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('public.reports.paid-requests.index'))->with('success', '有給申請を受理しました。');
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
