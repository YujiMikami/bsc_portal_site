<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\employee;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Support\Facades\Response;

class EmployeeController extends Controller
{
    private function getEmployeeQuery(Request $request)
    {
        $query = Employee::query();
        $column_array =[];

        if (isset($request->search_id_check)) {
            $column_array[] = 'employee_id';
        }
        
        if (isset($request->search_name_check)) {
            $column_array[] = 'employee_name';
        }

        if (isset($column_array[1])) {
            $query->select($column_array);
        } else {
            array_push($column_array, 'employee_id', 'employee_name', 'department_id', 'affiliation_id');
            $query->select($column_array);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $employee = $this->getEmployeeQuery($request)->get();
        return view('admin.table.employees.index', compact('employee'));
        
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
        return view('admin.table.employees.create');
    }

    public function show($employee_id)
    {
        try {
            $employee = Employee::findOrFail($employee_id);
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }


        // ビューにタスクデータを渡して表示
        return view('admin.table.employees.show', compact('employee'));
    }
    public function destroy($employee_id)
    {
        try {
            // 削除対象のタスクを取得。見つからなければ404エラー
            $employee = Employee::findOrFail($employee_id);

            // 論理削除を実行
            $employee->delete(); // SoftDeletesトレイトを使用していれば、deleted_atカラムが更新される
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.employees.index'))->with('success', 'タスクが正常に削除されました。');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validateEmployee($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // リダイレクト先を admin.tasks.create ルートに変更
            return redirect(route('admin.table.employees.create')) 
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }
        // Taskモデルのカスタムメソッドを使ってデータを保存
        $employee = new Employee();
        // $request オブジェクトを直接 saveTask メソッドに渡す
        try {
            $employee->saveEmployee($request); 

        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        return redirect(route('admin.table.employees.index'))->with('success', '社員登録が正常に処理されました。');
    }

    private function validateEmployee(Request $request)
    {
        $rules = [
            'employee_id' => 'required',
            'employee_name' => 'required',
            'portal_role' => 'required',
        ];

        $messages = [
            'employee_id.required' => ':attributeは必須項目です。',
            'employee_name.required' => ':attributeは必須項目です。',
            'portal_role.required' => ':attributeは必須項目です。',

        ];
        
        $attributes = [
            'employee_id' => '社員番号',
            'employee_name' => '社員名',
            'portal_role' => 'ポータル権限'
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }

    public function edit($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        // 補足: $post という変数名は $_POST と似ているため混同する可能性があります。
        // これを避けるには、例えば全件なら $postList、1件なら $postData のように、より具体的な変数名を使用すると良いでしょう。

        // 新規作成時と同じビュー ('posts.create') を再利用し、記事データを渡す
        return view('admin.table.employees.create', compact('employee'));
    }

    public function update(Request $request, $employee_id)
    {
        // バリデーション (新規作成時と同じ validateTask メソッドを再利用)
        $validator = $this->validateEmployee($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // 編集フォームのルートにリダイレクト
            return redirect(route('admin.table.employees.edit', $employee_id))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        try {
            $employee = Employee::findOrFail($employee_id);

            $employee->saveEmployee($request);
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.employees.index'))->with('success', '社員情報が正常に更新されました。');
    }

    public function downloadcsv(Request $request)
    {
        try {
            $employee = $this->getEmployeeQuery($request)->get();
        } catch (Exception $e) {
            Log::channel('alert')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
        }

        // CSVにするデータ配列
        $bufHead = [];
        $buf = [];
        isset($request->search_id_check) ? $bufHead[]='社員番号' : '';
        isset($request->search_name_check) ? $bufHead[]='社員名' : '';

        $data[] = $bufHead;

        foreach ($employee as $val) {
            isset($request->search_id_check) ? $buf[]=$val->employee_id: '';
            isset($request->search_name_check) ? $buf[]=$val->employee_name: '';
            $data[] = $buf;
            unset($buf);
        }

        // 保存するファイル名
        $date = new DateTime();
        $filename = 'employees_export_' . $date->format('YmdHis') . '.csv';

        // CSVのテキストを作成する変数
        $csv = '';

        // 配列の各行を処理
        foreach ($data as $row) {
            $escaped = [];
            foreach ($row as $value) {
            // 値をシングルクオートで囲み、内部のシングルクオートは2つに置換
                $escaped[] = '\'' . str_replace('\'', '\'\'', $value) . '\'';
            }
            // 行をカンマ区切りで連結し、改行コードを付加
            $csv .= implode(',', $escaped) . "\r\n";
        }
        // 文字コードをWindows向けのSJIS-winに変換
        $encodedCsv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
        // レスポンスを作成しCSVとしてブラウザに出力
        return Response::make($encodedCsv, 200, [
        'Content-Type' => 'text/csv; charset=SJIS',
        'Content-Disposition' => 'attachment; filename=' . $filename,
    ]);
    }
    
    public function configcsv()
    {
        return view('admin.table.employees.configcsv');
    }

}
