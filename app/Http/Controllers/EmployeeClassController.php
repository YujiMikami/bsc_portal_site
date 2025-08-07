<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeClass;
use App\Models\TableHistory;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.employee-classes.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
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

            $changes = [];
            foreach ($request->except(['_token', '_method']) as $column => $newValue) {
                if ($employeeClass->$column != $newValue) {
                    $changes[] = [
                        'table_name' => '社員区分',
                        'target_id' => $request->employee_class_id,
                        'target_name' => $request->employee_class_name,
                        'action' => '更新',
                        'item_name' => $column,
                        'before_update' => $employeeClass->$column,
                        'after_update' => $newValue,
                        'responder' => Auth::user()->employee_name,
                        'compatible_date' => now(),
                    ];
                }
            }

            $employeeClass->saveEmployeeClass($request);

            if (!empty($changes)) {
                TableHistory::insert($changes);
            }

        } catch (Exception $e) {
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.employee-classes.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
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
           
            TableHistory::create([
                'table_name' => '社員区分',
                'target_id' => $request->employee_class_id,
                'target_name' => $request->employee_class_name,
                'action' => '新規',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);    
       
        } catch (Exception $e) {
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.employee-classes.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.employee-classes.index'))->with('success', '社員区分情報が正常に登録されました。');
    }

    public function destroy($employeeClassId)
    {
        $employeeClass = EmployeeClass::findOrFail($employeeClassId);

        try {
            $employeeClass->delete();

            // TableHistoryに更新履歴を保存
            TableHistory::create([
                'table_name' => '社員区分',
                'target_id' => $employeeClassId,
                'target_name' => config('employee_classes.' . $employeeClassId),
                'action' => '削除',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);   

        } catch (Exception $e) {
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.employee-classes.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.employee-classes.index'))->with('success', '社員区分情報が正常に削除されました。');
    }

    private function validateEmployeeClass(Request $request)
    {
        $rules = [
            'employee_class_id' => 'required|digits_between:1,3|unique:employee_classes,employee_class_id',
            'employee_class_name' => 'required',
        ];

        $messages = [
            'employee_class_id.required' => ':attributeは必須項目です。',
            'employee_class_id.digits_between' => ':attributeは数字３桁以内です。',
            'employee_class_id.unique' => ':attributeはすでに登録されています。',
            'employee_class_name.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'employee_class_id' => '区分ID',
            'employee_class_name' => '区分名',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }

    public function importcsv()
    {
        return view('admin.table.employee-classes.importcsv');
    }

    public function uploadcsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file, 'r');

        if (!$handle) {
            return back()->with('error', 'ファイルを開けませんでした');
        }

        // ヘッダー行を読み飛ばす（必要に応じて）
        $header = fgetcsv($handle);

        DB::beginTransaction();
        try {
            while (($line = fgets($handle)) !== false) {
                // --- ① 文字コード自動判定 ---
                $encoding = mb_detect_encoding($line, ['SJIS-win', 'UTF-8', 'EUC-JP', 'ASCII'], true) ?: 'SJIS-win';

                // --- ② UTF-8に変換 ---
                $utf8Line = mb_convert_encoding($line, 'UTF-8', $encoding);

                // --- ③ CSVとして配列に ---
                $data = str_getcsv($utf8Line);

                if (count($data) < 2) {
                    throw new \Exception("CSV列数が不足しています");
                }

                EmployeeClass::updateOrCreate([
                    'employee_class_id' => $data[0],
                ], [
                    'employee_class_name' => $data[1],
                ]);

            }
            fclose($handle);
            DB::commit();
            return back()->with('success', 'インポートが完了しました');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.employee-classes.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }
    }
}
