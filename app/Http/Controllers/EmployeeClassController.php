<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeClass;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;

class EmployeeClassController extends Controller
{
    public function index()
    {
        $employeeClasses = EmployeeClass::all();
        return view('admin.table.employee-classes.index', compact('employeeClasses'));
    }

    public function create()
    {
        return view('admin.table.employee-classes.create');
    }

    public function show($employeeClassId)
    {
        try {
            $employeeClass = EmployeeClass::findOrFail($employeeClassId);
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        return view('admin.table.employee-classes.show', compact('employeeClass'));
    }
    public function edit($employeeClassId)
    {
        $employeeClass = EmployeeClass::findOrFail($employeeClassId);

        return view('admin.table.employee-classes.create', compact('employeeClass'));
    }

    public function update(Request $request, $employeeClassId)
    {
        // バリデーション
        $validator = $this->validateEmployeeClass($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // 編集フォームのルートにリダイレクト
            return redirect(route('admin.table.employee-classes.edit', $employeeClassId))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        try {
            $employeeClass = EmployeeClass::findOrFail($employeeClassId);
            $employeeClass->saveEmployeeClass($request);
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.employee-classes.index'))->with('success', '社員区分情報が正常に更新されました。');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validateEmployeeClass($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // リダイレクト先を admin.table.employee-classes.create ルートに変更
            return redirect(route('admin.table.employee-classes.create')) 
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }
        // Departmentモデルのカスタムメソッドを使ってデータを保存
        $employeeClass = new EmployeeClass();
        // $request オブジェクトを直接 saveDepartment メソッドに渡す
        try {
            $employeeClass->saveEmployeeClass($request); 

        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        return redirect(route('admin.table.employee-classes.index'))->with('success', '社員区分情報が正常に登録されました。');
    }

    public function destroy($employeeClassId)
    {
        try {
            // 削除対象のタスクを取得。見つからなければ404エラー
            $employeeClass = EmployeeClass::findOrFail($employeeClassId);

            // 論理削除を実行
            $employeeClass->delete(); // SoftDeletesトレイトを使用していれば、deleted_atカラムが更新される
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.employee-classes.index'))->with('success', '社員区分情報が正常に削除されました。');
    }

    private function validateEmployeeClass(Request $request)
    {
        $rules = [
            'employee_class_id' => 'required',
            'employee_class_name' => 'required',
        ];

        $messages = [
            'employee_class_id.required' => ':attributeは必須項目です。',
            'employee_class_name.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'employee_class_id' => '区分ID',
            'employee_class_name' => '区分名',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
}
