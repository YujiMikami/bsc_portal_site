<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliation;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;

class AffiliationController extends Controller
{
    public function index()
    {
        $affiliations = Affiliation::all();
        return view('admin.table.affiliations.index', compact('affiliations'));
    }

    public function create()
    {
        return view('admin.table.affiliations.create');
    }

    public function show($affiliation_id)
    {
        try {
            $affiliation = Affiliation::findOrFail($affiliation_id);
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        return view('admin.table.affiliations.show', compact('affiliation'));
    }
    public function edit($affiliation_id)
    {
        $affiliation = Affiliation::findOrFail($affiliation_id);

        return view('admin.table.affiliations.create', compact('affiliation'));
    }

    public function update(Request $request, $affiliation_id)
    {
        // バリデーション
        $validator = $this->validateAffiliation($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // 編集フォームのルートにリダイレクト
            return redirect(route('admin.table.affiliations.edit', $affiliation_id))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        try {
            $department = Affiliation::findOrFail($affiliation_id);
            $department->saveAffiliation($request);
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.affiliations.index'))->with('success', '所属情報が正常に更新されました。');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validateAffiliation($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // リダイレクト先を admin.table.affiliations.create ルートに変更
            return redirect(route('admin.table.affiliations.create')) 
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }
        // Departmentモデルのカスタムメソッドを使ってデータを保存
        $affiliation = new Affiliation();
        // $request オブジェクトを直接 saveAffiliation メソッドに渡す
        try {
            $affiliation->saveAffiliation($request); 

        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        return redirect(route('admin.table.affiliations.index'))->with('success', '所属情報が正常に登録されました。');
    }

    public function destroy($affiliation_id)
    {
        try {
            // 削除対象のタスクを取得。見つからなければ404エラー
            $affiliation = Affiliation::findOrFail($affiliation_id);

            // 論理削除を実行
            $affiliation->delete(); // SoftDeletesトレイトを使用していれば、deleted_atカラムが更新される
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.affiliations.index'))->with('success', '所属情報が正常に削除されました。');
    }

    private function validateAffiliation(Request $request)
    {
        $rules = [
            'affiliation_id' => 'required',
            'affiliation_name' => 'required',
        ];

        $messages = [
            'affiliation_id.required' => ':attributeは必須項目です。',
            'affiliation_name.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'affiliation_id' => '所属ID',
            'affiliation_name' => '所属名',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
}
