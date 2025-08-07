<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Occupation;
use App\Models\TableHistory;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.occupations.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
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

            $changes = [];
            foreach ($request->except(['_token', '_method']) as $column => $newValue) {
                if ($occupation->$column != $newValue) {
                    $changes[] = [
                        'table_name' => '職種',
                        'target_id' => $request->occupation_id,
                        'target_name' => $request->occupation_name,
                        'action' => '更新',
                        'item_name' => $column,
                        'before_update' => $occupation->$column,
                        'after_update' => $newValue,
                        'responder' => Auth::user()->employee_name,
                        'compatible_date' => now(),
                    ];
                }
            }

            $occupation->saveOccupation($request);

            if (!empty($changes)) {
                TableHistory::insert($changes);
            }

        } catch (Exception $e) {
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.occupations.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.occupations.index'))->with('success', '職種情報が正常に更新されました。');
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

            TableHistory::create([
                'table_name' => '職種',
                'target_id' => $request->occupation_id,
                'target_name' => $request->occupation_name,
                'action' => '新規',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);     

        } catch (Exception $e) {
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.occupations.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.occupations.index'))->with('success', '職種情報が正常に登録されました。');
    }

    public function destroy($occupation_id)
    {
        try {
            $occupation = Occupation::findOrFail($occupation_id);

            $occupation->delete();
    
            TableHistory::create([
                'table_name' => '職種',
                'target_id' => $occupation_id,
                'target_name' => config('occupations.' . $occupation_id),
                'action' => '削除',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);

        } catch (Exception $e) {
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.occupations.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.occupations.index'))->with('success', '職種情報が正常に削除されました。');
    }

    private function validateOccupation(Request $request)
    {
        $rules = [
            'occupation_id' => 'required|digits_between:1,3|unique:occupations,occupation_id',
            'occupation_name' => 'required',
        ];

        $messages = [
            'occupation_id.required' => ':attributeは必須項目です。',
            'occupation_id.digits_between' => ':attributeは数字３桁以内です。',
            'occupation_id.unique' => ':attributeはすでに登録されています。',
            'occupation_name.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'occupation_id' => '職種ID',
            'occupation_name' => '職種名',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }

    public function importcsv()
    {
        return view('admin.table.occupations.importcsv');
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

                Occupation::updateOrCreate([
                    'occupation_id' => $data[0],
                ], [
                    'occupation_name' => $data[1],
                ]);

            }
            fclose($handle);
            DB::commit();
            return back()->with('success', 'インポートが完了しました');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('error')->alert('予期せぬエラーが発生しました。', [$e->getMessage()]);
            return redirect(route('admin.table.occupations.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }
    }
}
