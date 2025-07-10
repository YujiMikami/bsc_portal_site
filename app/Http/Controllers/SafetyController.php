<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Safety;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;

class SafetyController extends Controller
{
        /**
     * ルーティングで指定されたURLへのリクエストがあったときに実行されるメソッド
     */
    public function index()
    {
        $safety = Safety::all();
        
        return view('admin.safety.index', compact('safety'));
        
        // データをViewに渡す場合は
        // return view('my-page', ['data' => $data, 'id' => $id]);や
        // return view('my-page', compact('data', 'id'));
        // のようにします
        
        // ビューファイルがサブディレクトリにある場合、ドット(.)で区切って指定します。
        // 例: resources/views/admin/users/index.blade.php を表示する場合
        // return view('admin.users.index'); // <-- サブディレクトリの例
    }

    public function create()
    {
        return view('admin.safety.create');
    }
    
    public function store(Request $request)
    {
        // バリデーション
        //$validator = $this->validateSafety($request);

        // バリデーションに失敗した場合
        // if ($validator->fails()) {
        //     // リダイレクト先を admin.tasks.create ルートに変更
        //     return redirect(route('admin.safety.index')) 
        //         ->withErrors($validator) // エラーメッセージをセッションに保存
        //         ->withInput(); // 直前に入力されたデータをセッションに保存
        // }

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
        return redirect(route('admin.safety.index'))->with('success', '安否報告が正常に登録されました。');
    }

    private function validateSafety(Request $request)
    {
        $rules = [
            'title' => 'required|max:100',
            'content' => 'required|max:1000',
            'deadline_at' => 'required',
        ];

        $messages = [
            'title.required' => ':attributeは必須項目です。',
            'title.max' => ':attributeは:max文字以内で入力してください。',
            'content.required' => ':attributeは必須項目です。',
            'content.max' => ':attributeは:max文字以内で入力してください。',
            'deadline_at.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'title' => 'タイトル',
            'content' => '内容',
            'deadline_at' => '対応期限',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
    
}
