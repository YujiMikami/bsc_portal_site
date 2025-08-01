<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Safety;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class SafetyController extends Controller
{
        /**
     * ルーティングで指定されたURLへのリクエストがあったときに実行されるメソッド
     */
    public function index()
    {
        if (Auth::user()->role == 1) {
            $safety = Safety::all();
        } else {
            $safety = Safety::where('safety_employee_id', auth::user()->employee_id)->get();
        }
          
        return view('public.reports.safety.index', compact('safety'));
    }

    public function create()
    {
        return view('public.reports.safety.create');
    }
    
    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validateSafety($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // リダイレクト先を admin.tasks.create ルートに変更
            return redirect(route('public.reports.safety.create')) 
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        // Taskモデルのカスタムメソッドを使ってデータを保存
        $safety = new Safety();
        // $request オブジェクトを直接 saveTask メソッドに渡す
        try {
            $safety->saveSafety($request); 

        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // /admin/tasks にリダイレクトする（既に定義済みのタスク一覧ページなどへ）
        // 成功メッセージをセッションにフラッシュデータとして保存
        return redirect(route('public.reports.safety.index'))->with('success', '安否報告が正常に登録されました。');
    }

    private function validateSafety(Request $request)
    {
        $rules = [
            'department' => 'required',
            'affiliation' => 'required',
            'safety_status' => 'required',
            'can_work' => 'required',
        ];

        $messages = [
            'department.required' => ':attributeは必須項目です。',
            'affiliation.required' => ':attributeは必須項目です。',
            'safety_status.required' => ':attributeは必須項目です。',
            'can_work.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'department' => '部署',
            'affiliation' => '所属',
            'safety_status' => 'ケガの有無',
            'can_work' => '出社可否',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
    public function destroy($id)
    {
        try {
            // 削除対象のタスクを取得。見つからなければ404エラー
            $safety = safety::findOrFail($id);

            // 論理削除を実行
            $safety->delete(); // SoftDeletesトレイトを使用していれば、deleted_atカラムが更新される
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('public.reports.safety.index'))->with('success', 'タスクが正常に削除されました。');
    }
}
