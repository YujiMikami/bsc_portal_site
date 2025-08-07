<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliation;
use App\Models\TableHistory;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            Log::channel('error')->alert('所属テーブルエラー(AffiliationController->show)', [$e->getMessage()]);
            return redirect(route('admin.table.affiliations.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
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

        // TableHistoryに更新履歴を保存
        try {
            $affiliation = Affiliation::findOrFail($affiliation_id);
            $changes = [];

            // 更新した項目の数、レコードを追加
            foreach ($request->except(['_token', '_method']) as $column => $newValue) {
                if ($affiliation->$column != $newValue) {
                    $changes[] = [
                        'table_name' => '所属',
                        'target_id' => $request->affiliation_id,
                        'target_name' => $request->affiliation_name,
                        'action' => '更新',
                        'item_name' => $column,
                        'before_update' => $affiliation->$column,
                        'after_update' => $newValue,
                        'responder' => Auth::user()->employee_name,
                        'compatible_date' => now(),
                    ];
                }
            }
            
            $affiliation->saveAffiliation($request);

            if (!empty($changes)) {
                TableHistory::insert($changes);
            }

        } catch (Exception $e) {
            Log::channel('error')->alert('所属テーブルエラー(AffiliationController->update)', [$e->getMessage()]);
            return redirect(route('admin.table.affiliations.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

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
        
        $affiliation = new Affiliation();

        try {
            $affiliation->saveAffiliation($request); 

            // TableHistoryに更新履歴を保存
            TableHistory::create([
                'table_name' => '所属',
                'target_id' => $request->affiliation_id,
                'target_name' => $request->affiliation_name,
                'action' => '新規',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);

        } catch (Exception $e) {
            Log::channel('error')->alert('所属テーブルエラー(AffiliationController->store)', [$e->getMessage()]);
            return redirect(route('admin.table.affiliations.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.affiliations.index'))->with('success', '所属情報が正常に登録されました。');
    }

    public function destroy($affiliation_id)
    {
        try {
            $affiliation = Affiliation::findOrFail($affiliation_id);

            $affiliation->delete();

            // TableHistoryに更新履歴を保存
            TableHistory::create([
                'table_name' => '所属',
                'target_id' => $affiliation_id,
                'target_name' => config('affiliations.' . $affiliation_id),
                'action' => '削除',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);            

        } catch (Exception $e) {
            Log::channel('error')->alert('所属テーブルエラー(AffiliationController->destroy)', [$e->getMessage()]);
            return redirect(route('admin.table.affiliations.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.affiliations.index'))->with('success', '所属情報が正常に削除されました。');
    }

    private function validateAffiliation(Request $request)
    {
        $rules = [
            'affiliation_id' => 'required|digits_between:1,3|unique:affiliations,affiliation_id',
            'affiliation_name' => 'required',
        ];

        $messages = [
            'affiliation_id.required' => ':attributeは必須項目です。',
            'affiliation_id.digits_between' => ':attributeは数字３桁以内です。',
            'affiliation_id.unique' => ':attributeはすでに登録されています。',
            'affiliation_name.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'affiliation_id' => '所属ID',
            'affiliation_name' => '所属名',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }

    public function importcsv()
    {
        return view('admin.table.affiliations.importcsv');
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

        // ヘッダー行を読み飛ばす
        $header = fgetcsv($handle);

        DB::beginTransaction();
        try {
            while (($line = fgets($handle)) !== false) {
                // --- 文字コード自動判定 ---
                $encoding = mb_detect_encoding($line, ['SJIS-win', 'UTF-8', 'EUC-JP', 'ASCII'], true) ?: 'SJIS-win';

                // --- UTF-8に変換 ---
                $utf8Line = mb_convert_encoding($line, 'UTF-8', $encoding);

                // --- CSVとして配列に ---
                $data = str_getcsv($utf8Line);

                if (count($data) < 3) {
                    throw new \Exception("CSV列数が不足しています");
                }

                Affiliation::updateOrCreate([
                    'affiliation_id' => $data[0],
                ], [
                    'affiliation_name' => $data[1],
                    'affiliation_explanation' => $data[2],
                ]);

            }
            fclose($handle);
            DB::commit();
            return back()->with('success', 'インポートが完了しました');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('error')->alert('所属テーブルエラー(AffiliationController->uploadcsv)', [$e->getMessage()]);
            return redirect(route('admin.table.affiliations.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }
    }
}
