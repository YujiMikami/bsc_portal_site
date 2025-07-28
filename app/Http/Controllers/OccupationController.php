<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Occupation;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;

class OccupationController extends Controller
{
    public function index()
    {
        $occupations = Occupation::all();
        return view('admin.table.occupations.index', compact('occupations'));
    }

    public function create()
    {
        return view('admin.table.occupations.create');
    }

    public function show($occupation_id)
    {
        try {
            $occupation = Occupation::findOrFail($occupation_id);
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        return view('admin.table.occupations.show', compact('occupation'));
    }
    public function edit($occupation_id)
    {
        $occupation = Occupation::findOrFail($occupation_id);

        return view('admin.table.occupations.create', compact('occupation'));
    }

    public function update(Request $request, $occupation_id)
    {
        // バリデーション
        $validator = $this->validateOccupation($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // 編集フォームのルートにリダイレクト
            return redirect(route('admin.table.occupation.edit', $occupation_id))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        try {
            $occupation = Occupation::findOrFail($occupation_id);
            $occupation->saveOccupation($request);
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.occupation.index'))->with('success', '職種情報が正常に更新されました。');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validateOccupation($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // リダイレクト先を admin.table.occupations.create ルートに変更
            return redirect(route('admin.table.occupations.create')) 
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }
        // Occupationモデルのカスタムメソッドを使ってデータを保存
        $occupation = new Occupation();
        // $request オブジェクトを直接 saveOccupation メソッドに渡す
        try {
            $occupation->saveOccupation($request); 
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        return redirect(route('admin.table.occupations.index'))->with('success', '職種情報が正常に登録されました。');
    }

    public function destroy($occupation_id)
    {
        try {
            // 削除対象のタスクを取得。見つからなければ404エラー
            $occupation = Occupation::findOrFail($occupation_id);

            // 論理削除を実行
            $occupation->delete(); // SoftDeletesトレイトを使用していれば、deleted_atカラムが更新される
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.occupations.index'))->with('success', '職種情報が正常に削除されました。');
    }

    private function validateOccupation(Request $request)
    {
        $rules = [
            'occupation_id' => 'required',
            'occupation_name' => 'required',
        ];

        $messages = [
            'occupation_id.required' => ':attributeは必須項目です。',
            'occupation_name.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'occupation_id' => '職種ID',
            'occupation_name' => '職種名',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
}
