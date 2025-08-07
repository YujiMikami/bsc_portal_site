<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeePost;
use App\Models\TableHistory;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeePostController extends Controller
{
    public function index()
    {
        $employeePosts = EmployeePost::all();
        return view('admin.table.employee-posts.index', compact('employeePosts'));
    }

    public function create()
    {
        return view('admin.table.employee-posts.create');
    }

    public function show($employeePostId)
    {
        try {
            $employeePost = EmployeePost::findOrFail($employeePostId);
        } catch (Exception $e) {
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.employee-posts.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return view('admin.table.employee-posts.show', compact('employeePost'));
    }
    public function edit($employeePostId)
    {
        $employeePost = EmployeePost::findOrFail($employeePostId);

        return view('admin.table.employee-posts.create', compact('employeePost'));
    }

    public function update(Request $request, $employeePostId)
    {
        // バリデーション
        $validator = $this->validateEmployeePost($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // 編集フォームのルートにリダイレクト
            return redirect(route('admin.table.employee-posts.edit', $employeePostId))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        try {
            $employeePost = EmployeePost::findOrFail($employeePostId);

            $changes = [];
            foreach ($request->except(['_token', '_method']) as $column => $newValue) {
                if ($employeePost->$column != $newValue) {
                    $changes[] = [
                        'table_name' => '役職',
                        'target_id' => $request->employee_post_id,
                        'target_name' => $request->employee_post_name,
                        'action' => '更新',
                        'item_name' => $column,
                        'before_update' => $employeePost->$column,
                        'after_update' => $newValue,
                        'responder' => Auth::user()->employee_name,
                        'compatible_date' => now(),
                    ];
                }
            }

            $employeePost->saveEmployeePost($request);

            if (!empty($changes)) {
                TableHistory::insert($changes);
            }

        } catch (Exception $e) {
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.employee-posts.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.employee-posts.index'))->with('success', '役職情報が正常に更新されました。');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validateEmployeePost($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // リダイレクト先を admin.table.employeePosts.create ルートに変更
            return redirect(route('admin.table.employee-posts.create')) 
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }



        // EmployeePostモデルのカスタムメソッドを使ってデータを保存
        $employeePost = new EmployeePost();
        // $request オブジェクトを直接 saveEmployeePost メソッドに渡す
        try {
            $employeePost->saveEmployeePost($request); 
        
            TableHistory::create([
                'table_name' => '役職',
                'target_id' => $request->employee_post_id,
                'target_name' => $request->employee_post_name,
                'action' => '新規',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);   
        
        } catch (Exception $e) {
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.employee-posts.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.employee-posts.index'))->with('success', '役職情報が正常に登録されました。');
    }

    public function destroy($employeePostId)
    {
        try {
            $employeePost = EmployeePost::findOrFail($employeePostId);
            
            $employeePost->delete();
            
            // TableHistoryに更新履歴を保存
            TableHistory::create([
                'table_name' => '役職',
                'target_id' => $employeePostId,
                'target_name' => config('employee_posts.' . $employeePostId),
                'action' => '削除',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);

        } catch (Exception $e) {
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.employee-posts.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.employee-posts.index'))->with('success', '役職情報が正常に削除されました。');
    }

    private function validateEmployeePost(Request $request)
    {
        $rules = [
            'employee_post_id' => 'required|digits_between:1,3|unique:employee_posts,employee_post_id',
            'employee_post_name' => 'required',
        ];

        $messages = [
            'employee_post_id.required' => ':attributeは必須項目です。',
            'employee_post_id.digits_between' => ':attributeは数字３桁以内です。',
            'employee_post_id.unique' => ':attributeはすでに登録されています。',
            'employee_post_name.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'employee_post_id' => '役職ID',
            'employee_post_name' => '役職名',
         ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }

    public function importcsv()
    {
        return view('admin.table.employee-posts.importcsv');
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

                EmployeePost::updateOrCreate([
                    'employee_post_id' => $data[0],
                ], [
                    'employee_post_name' => $data[1],
                ]);

            }
            fclose($handle);
            DB::commit();
            return back()->with('success', 'インポートが完了しました');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.employee-posts.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }
    }
}

