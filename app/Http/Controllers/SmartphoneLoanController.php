<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmartphoneLoan;
use App\Models\TableHistory;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SmartphoneLoanController extends Controller
{
    public function index()
    {
        $smartphoneLoans = SmartphoneLoan::all();
        return view('admin.table.smartphone-loans.index', compact('smartphoneLoans'));
    }

    public function create()
    {
        return view('admin.table.smartphone-loans.create');
    }

    public function show($id)
    {
        try {
            $smartphoneLoan = SmartphoneLoan::findOrFail($id);
        } catch (Exception $e) {
            Log::channel('error')->alert('スマートフォン貸与テーブルエラー(SmartphoneLoanController->show)', [$e->getMessage()]);
            return redirect(route('admin.table.smartphone-loans.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return view('admin.table.smartphone-loans.show', compact('smartphoneLoan'));
    }

    public function edit($id)
    {
        $smartphoneLoan = SmartphoneLoan::findOrFail($id);

        return view('admin.table.smartphone-loans.create', compact('smartphoneLoan'));
    }

    public function update(Request $request, $id)
    {
        // バリデーション
        $validator = $this->validateSmartphoneLoan($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // 編集フォームのルートにリダイレクト
            return redirect(route('admin.table.smartphone-loans.edit', $id))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        try {
            $smartphoneLoan = SmartphoneLoan::findOrFail($id);

            $changes = [];
            foreach ($request->except(['_token', '_method']) as $column => $newValue) {
                if ($smartphoneLoan->$column != $newValue) {
                    $changes[] = [
                        'table_name' => 'スマートフォン貸与',
                        'target_id' => $request->id,
                        'target_name' => $request->phone_number,
                        'action' => '更新',
                        'item_name' => $column,
                        'before_update' => $smartphoneLoan->$column,
                        'after_update' => $newValue,
                        'responder' => Auth::user()->employee_name,
                        'compatible_date' => now(),
                    ];
                }
            }

            $smartphoneLoan->saveSmartphoneLoan($request);

            if (!empty($changes)) {
                TableHistory::insert($changes);
            }
        } catch (Exception $e) {
            Log::channel('error')->alert('スマートフォン貸与テーブルエラー(SmartphoneLoanController->update)', [$e->getMessage()]);
            return redirect(route('admin.table.smartphone-loans.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.smartphone-loans.index'))->with('success', '貸与情報が正常に更新されました。');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validateSmartphoneLoan($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            return redirect(route('admin.table.smartphone-loans.create'))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        // saveSmartphoneLoanモデルのカスタムメソッドを使ってデータを保存
        $smartphoneLoan = new SmartphoneLoan();
        // $request オブジェクトを直接 saveSmartphoneLoan メソッドに渡す
        try {
            $smartphoneLoan->saveSmartphoneLoan($request);
            TableHistory::create([
                'table_name' => 'スマートフォン貸与',
                'target_id' => $smartphoneLoan->id,
                'target_name' => $request->phone_number,
                'action' => '新規',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);
        } catch (Exception $e) {
            Log::channel('error')->alert('スマートフォン貸与テーブルエラー(SmartphoneLoanController->store)', [$e->getMessage()]);
            return redirect(route('admin.table.smartphone-loans.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.smartphone-loans.index'))->with('success', '貸与情報が正常に登録されました。');
    }

    public function destroy($id)
    {
        try {
            $smartphoneLoan = SmartphoneLoan::findOrFail($id);

            $smartphoneLoan->delete();

            // TableHistoryに更新履歴を保存
            TableHistory::create([
                'table_name' => 'スマートフォン貸与',
                'target_id' => $smartphoneLoan->id,
                'target_name' => $smartphoneLoan->phone_number,
                'action' => '削除',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);
        } catch (Exception $e) {
            Log::channel('error')->alert('スマートフォン貸与テーブルエラー(SmartphoneLoanController->destroy)', [$e->getMessage()]);
            return redirect(route('admin.table.smartphone-loans.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.smartphone-loans.index'))->with('success', '貸与情報が正常に削除されました。');
    }

    private function validateSmartphoneLoan(Request $request)
    {
        $rules = [
            'phone_number' => 'required',
        ];

        $messages = [
            'phone_number.required' => ':attributeは必須項目です。',
        ];

        $attributes = [
            'phone_number' => '電話番号',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
}
