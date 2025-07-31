<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $inRetiredPersons = $request->in_retired_persons;
            $query = Employee::with(['department', 'affiliation']);
            if (!$inRetiredPersons) {
                $query->whereNull('retirement_date');
            }
            $employees = $query->get();

            return view('admin.table.employees.index', compact('employees', 'inRetiredPersons'));
        } catch (QueryException $e) {
            Log::error('DBクエリエラー: ' . $e->getMessage());
            return back()->with('error', '社員データの取得に失敗しました。');
        } catch (Exception $e) {
            Log::error('一般エラー: ' . $e->getMessage());
            return back()->with('error', '予期せぬエラーが発生しました。');
        }
    }

    public function create()
    {
        return view('admin.table.employees.create');
    }

    public function show($employee_id)
    {
        try {
            $employee = Employee::with([
                'department',
                'affiliation',
                'occupation',
                'employeeClass',
                'employeePost',
            ])->findOrFail($employee_id);
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
            'gender' => 'required',
            'employee_class_id' => 'required',
            'hire_date' => 'required',
            'portal_role' => 'required',
        ];

        $messages = [
            'employee_id.required' => ':attributeは必須項目です。',
            'employee_name.required' => ':attributeは必須項目です。',
            'gender.required' => ':attributeは必須項目です。',
            'employee_class_id.required' => ':attributeは必須項目です。',
            'hire_date.required' => ':attributeは必須項目です。',
            'portal_role.required' => ':attributeは必須項目です。',

        ];
        
        $attributes = [
            'employee_id' => '社員番号',
            'employee_name' => '社員名',
            'gender' => '性別',
            'employee_class_id' => '社員区分',
            'hire_date' => '入社日',
            'portal_role' => 'ポータル権限'
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }

    public function edit($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
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
        $columns = $request->input('columns', []);
        $inRetiredPersons = $request->input('in_retired_persons');
        $employeeClassId = $request->input('employee_class_id');
        $departmentId = $request->input('department_id');
        $affiliationId = $request->input('affiliation_id');
        $occupationId = $request->input('occupation_id');

        $query = Employee::with([
            'employeeClass',
            'department',
            'affiliation',
            'occupation'
        ]);

        if (!$inRetiredPersons) {
            $query->whereNull('retirement_date'); // 退職者を除外
        }
        if ($employeeClassId) {
            $query->where('employee_class_id', $employeeClassId);
        }
        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }
        if ($affiliationId) {
            $query->where('affiliation_id', $affiliationId);
        }
        if ($occupationId) {
            $query->where('occupation_id', $occupationId);
        }

        $employees = $query->get();

        // データ整形
        $csvData = [];
        foreach ($employees as $employee) {
            $row = [];
            foreach ($columns as $col) {
                switch ($col) {
                    case 'gender':
                        $row[] = config('const.gender.' . $employee->$col);
                        break;
                    case 'employee_class_name':
                        $row[] = $employee->employeeClass->employee_class_name ?? '';
                        break;
                    case 'department_name':
                        $row[] = $employee->department->department_name ?? '';
                        break;
                    case 'affiliation_name':
                        $row[] = $employee->affiliation->affiliation_name ?? '';
                        break;
                    case 'occupation_name':
                        $row[] = $employee->occupation->occupation_name ?? '';
                        break;
                    default:
                        $row[] = $employee->$col ?? '';
                        break;
                }
            }
            $csvData[] = $row;
        }

        // CSV文字列作成
        $csv = implode(',', $columns) . "\n";
        foreach ($csvData as $row) {
            $csv .= implode(',', array_map(fn($val) => '"' . str_replace('"', '""', $val) . '"', $row)) . "\n";
        }

        // エンコーディングとダウンロード
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
        $filename = 'employees_' . now()->format('Ymd_His') . '.csv';

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv; charset=Shift_JIS',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
    
    public function exportcsv()
    {
        return view('admin.table.employees.exportcsv');
    }
    
    public function importcsv()
    {
        return view('admin.table.employees.importcsv');
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

                if (count($data) < 58) {
                    throw new \Exception("CSV列数が不足しています");
                }
                
                Employee::updateOrCreate([
                    'employee_id' => $data[0],
                ], [
                    'employee_name' => $data[1],
                    'employee_name_furigana' => $data[2],
                    'gender' => $data[3],
                    'employee_class_id' => $data[4],
                    'department_id' => toIntOrNull($data[5]),
                    'affiliation_id' => toIntOrNull($data[6]),
                    'occupation_id' => toIntOrNull($data[7]),
                    'birth_date' => normalizeDateOrNull($data[8]),
                    'hire_date' => $data[9],
                    'post_code' => toIntOrNull($data[10]),
                    'prefecture' => toIntOrNull($data[11]),
                    'municipalitie' => toIntOrNull($data[12]),
                    'address_2' => toIntOrNull($data[13]),
                    'address_3' => toIntOrNull($data[14]),
                    'phone_number' => toIntOrNull($data[15]),
                    'mobile_phone_number' => toIntOrNull($data[16]),
                    'final_academic_date' => normalizeDateOrNull($data[17]),
                    'final_academic' => toIntOrNull($data[18]),
                    'work_history_1_date' => normalizeDateOrNull($data[19]),
                    'work_history_1' => toIntOrNull($data[20]),
                    'work_history_2_date' => normalizeDateOrNull($data[21]),
                    'work_history_2' => toIntOrNull($data[22]),
                    'work_history_3_date' => normalizeDateOrNull($data[23]),
                    'work_history_3' => toIntOrNull($data[24]),
                    'work_history_4_date' => normalizeDateOrNull($data[25]),
                    'work_history_4' => toIntOrNull($data[26]),
                    'work_history_5_date' => normalizeDateOrNull($data[27]),
                    'work_history_5' => toIntOrNull($data[28]),
                    'work_history_6_date' => normalizeDateOrNull($data[29]),
                    'work_history_6' => toIntOrNull($data[30]),
                    'work_history_7_date' => normalizeDateOrNull($data[31]),
                    'work_history_7' => toIntOrNull($data[32]),
                    'work_history_8_date' => normalizeDateOrNull($data[33]),
                    'work_history_8' => toIntOrNull($data[34]),
                    'work_history_9_date' => normalizeDateOrNull($data[35]),
                    'work_history_9' => toIntOrNull($data[36]),
                    'work_history_10_date' => normalizeDateOrNull($data[37]),
                    'work_history_10' => toIntOrNull($data[38]),
                    'license_1' => toIntOrNull($data[39]),
                    'license_2' => toIntOrNull($data[40]),
                    'license_3' => toIntOrNull($data[41]),
                    'license_4' => toIntOrNull($data[42]),
                    'license_5' => toIntOrNull($data[43]),
                    'social_insurance_Applicable_date' => normalizeDateOrNull($data[44]),
                    'health_insurance' => toIntOrNull($data[45]),
                    'basic_pension_number' => toIntOrNull($data[46]),
                    'welfare_pension_number' => toIntOrNull($data[47]),
                    'health_insurance_basic_reward_monthly_fee' => toIntOrNull($data[48]),
                    'health_insurance_grade' => toIntOrNull($data[49]),
                    'pension_basic_reward_monthly_fee' => toIntOrNull($data[50]),
                    'pension_grade' => toIntOrNull($data[51]),
                    'employment_applicable_date' => normalizeDateOrNull($data[52]),
                    'applicable_insurance' => toIntOrNull($data[53]),
                    'affiliation_updated_at' => normalizeDateOrNull($data[54]),
                    'retirement_date' => normalizeDateOrNull($data[55]),
                    'retirement_reason' => toIntOrNull($data[56]),
                    'note' => toIntOrNull($data[57]),
                    'password' => Hash::make('bsc' . $data[0]),
                    'portal_role' => 99,
                    'updated_by' => Auth::user()->employee_name,
                ]);
            }
            fclose($handle);
            DB::commit();
            return back()->with('success', 'インポートが完了しました');
        } catch (\Exception $e) {
        
            DB::rollBack();
            return back()->with('error', 'エラー: ' . $e->getMessage());
        }
    }
}
