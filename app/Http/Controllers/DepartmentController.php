<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('admin.table.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.table.departments.create');
    }

    public function show($department_id)
    {
        try {
            $department = Department::findOrFail($department_id);
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        return view('admin.table.departments.show', compact('department'));
    }
    public function edit($department_id)
    {
        $department = Department::findOrFail($department_id);

        return view('admin.table.departments.create', compact('department'));
    }

    public function update(Request $request, $department_id)
    {
        // バリデーション
        $validator = $this->validateDepartment($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // 編集フォームのルートにリダイレクト
            return redirect(route('admin.table.departments.edit', $department_id))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        try {
            $department = Department::findOrFail($department_id);
            $department->saveDepartment($request);
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.departments.index'))->with('success', '部署情報が正常に更新されました。');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validateDepartment($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // リダイレクト先を admin.table.departments.create ルートに変更
            return redirect(route('admin.table.departments.create')) 
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }
        // Departmentモデルのカスタムメソッドを使ってデータを保存
        $department = new Department();
        // $request オブジェクトを直接 saveDepartment メソッドに渡す
        try {
            $department->saveDepartment($request); 
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        return redirect(route('admin.table.departments.index'))->with('success', '部署情報が正常に登録されました。');
    }

    public function destroy($department_id)
    {
        try {
            // 削除対象のタスクを取得。見つからなければ404エラー
            $department = Department::findOrFail($department_id);

            // 論理削除を実行
            $department->delete(); // SoftDeletesトレイトを使用していれば、deleted_atカラムが更新される
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.departments.index'))->with('success', '部署情報が正常に削除されました。');
    }

    private function validateDepartment(Request $request)
    {
        $rules = [
            'department_id' => 'required',
            'department_name' => 'required',
        ];

        $messages = [
            'department_id.required' => ':attributeは必須項目です。',
            'department_name.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'department_id' => '部署ID',
            'department_name' => '部署名',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
}
