<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\TableHistory;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            Log::channel('error')->alert('部署テーブルエラー(DepartmentController->show)', [$e->getMessage()]);
            return redirect(route('admin.table.departments.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
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

            $changes = [];
            foreach ($request->except(['_token', '_method']) as $column => $newValue) {
                if ($department->$column != $newValue) {
                    $changes[] = [
                        'table_name' => '部署',
                        'target_id' => $request->department_id,
                        'target_name' => $request->department_name,
                        'action' => '更新',
                        'item_name' => $column,
                        'before_update' => $department->$column,
                        'after_update' => $newValue,
                        'responder' => Auth::user()->employee_name,
                        'compatible_date' => now(),
                    ];
                }
            }

            $department->saveDepartment($request);

            if (!empty($changes)) {
                TableHistory::insert($changes);
            }

        } catch (Exception $e) {
            Log::channel('error')->alert('部署テーブルエラー(DepartmentController->update)', [$e->getMessage()]);
            return redirect(route('admin.table.departments.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.departments.index'))->with('success', '部署情報が正常に更新されました。');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validateDepartment($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            return redirect(route('admin.table.departments.create')) 
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }
        
        $department = new Department();

        try {
            $department->saveDepartment($request); 
        
            TableHistory::create([
                'table_name' => '部署',
                'target_id' => $request->department_id,
                'target_name' => $request->department_name,
                'action' => '新規',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);      
        
        } catch (Exception $e) {
            Log::channel('error')->alert('部署テーブルエラー(DepartmentController->store)', [$e->getMessage()]);
            return redirect(route('admin.table.departments.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.departments.index'))->with('success', '部署情報が正常に登録されました。');
    }

    public function destroy($department_id)
    {
        try {
            $department = Department::findOrFail($department_id);

            $department->delete();

            // TableHistoryに更新履歴を保存
            TableHistory::create([
                'table_name' => '部署',
                'target_id' => $department_id,
                'target_name' => config('departments.' . $department_id),
                'action' => '削除',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);   



        } catch (Exception $e) {
            Log::channel('error')->alert('部署テーブルエラー(DepartmentController->destroy)', [$e->getMessage()]);
            return redirect(route('admin.table.departments.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.departments.index'))->with('success', '部署情報が正常に削除されました。');
    }

    private function validateDepartment(Request $request)
    {
        $rules = [
            'department_id' => 'required|digits_between:1,3|unique:departments,department_id',
            'department_name' => 'required',
        ];

        $messages = [
            'department_id.required' => ':attributeは必須項目です。',
            'department_id.digits_between' => ':attributeは数字３桁以内です。',
            'department_id.unique' => ':attributeはすでに登録されています。',
            'department_name.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'department_id' => '部署ID',
            'department_name' => '部署名',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }

    public function importcsv()
    {
        return view('admin.table.departments.importcsv');
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

                if (count($data) < 3) {
                    throw new \Exception("CSV列数が不足しています");
                }

                Department::updateOrCreate([
                    'department_id' => $data[0],
                ], [
                    'department_name' => $data[1],
                    'department_explanation' => $data[2],
                ]);

            }
            fclose($handle);
            DB::commit();
            return back()->with('success', 'インポートが完了しました');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('error')->alert('部署テーブルエラー(DepartmentController->uploadcsv)', [$e->getMessage()]);
            return redirect(route('admin.table.departments.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }
    }
}
