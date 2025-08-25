<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PcLoan;
use App\Models\TableHistory;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PcLoanController extends Controller
{
public function index()
    {
        $pcLoans = PcLoan::all();
        return view('admin.table.pc-loans.index', compact('pcLoans'));
    }

    public function create()
    {
        return view('admin.table.pc-loans.create');
    }

    public function show($id)
    {
        try {
            $pcLoan = PcLoan::findOrFail($id);
        } catch (Exception $e) {
            Log::channel('error')->alert('ＰＣ貸与テーブルエラー(PcLoanController->show)', [$e->getMessage()]);
            return redirect(route('admin.table.pc-loans.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return view('admin.table.pc-loans.show', compact('pcLoan'));
    }
    
    public function edit($id)
    {
        $pcLoan = PcLoan::findOrFail($id);

        return view('admin.table.pc-loans.create', compact('pcLoan'));
    }

    public function update(Request $request, $id)
    {
        // バリデーション
        $validator = $this->validatePcLoan($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // 編集フォームのルートにリダイレクト
            return redirect(route('admin.table.pc-loans.edit', $id))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        try {
            $pcLoan = PcLoan::findOrFail($id);

            $changes = [];
            foreach ($request->except(['_token', '_method']) as $column => $newValue) {
                if ($pcLoan->$column != $newValue) {
                    $changes[] = [
                        'table_name' => 'ＰＣ貸与',
                        'target_id' => $request->id,
                        'target_name' => $request->pc_number,
                        'action' => '更新',
                        'item_name' => $column,
                        'before_update' => $pcLoan->$column,
                        'after_update' => $newValue,
                        'responder' => Auth::user()->employee_name,
                        'compatible_date' => now(),
                    ];
                }
            }

            $pcLoan->savePcLoan($request);

            if (!empty($changes)) {
                TableHistory::insert($changes);
            }

        } catch (Exception $e) {
            Log::channel('error')->alert('ＰＣ貸与テーブルエラー(PcLoanController->update)', [$e->getMessage()]);
            return redirect(route('admin.table.pc-loans.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.pc-loans.index'))->with('success', '貸与情報が正常に更新されました。');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validatePcLoan($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            return redirect(route('admin.table.pc-loans.create')) 
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        // saveSmartphoneLoanモデルのカスタムメソッドを使ってデータを保存
        $pcLoan = new PcLoan();
        // $request オブジェクトを直接 saveSmartphoneLoan メソッドに渡す
        try {
            $pcLoan->savePcLoan($request); 
            TableHistory::create([
                'table_name' => 'ＰＣ貸与',
                'target_id' => $pcLoan->id,
                'target_name' => $request->pc_number,
                'action' => '新規',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);   
        
        } catch (Exception $e) {
            Log::channel('error')->alert('ＰＣ貸与テーブルエラー(PcController->store)', [$e->getMessage()]);
            return redirect(route('admin.table.pc-loans.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.table.pc-loans.index'))->with('success', '貸与情報が正常に登録されました。');
    }

    public function destroy($id)
    {
        try {
            $pcLoan = PcLoan::findOrFail($id);
            
            $pcLoan->delete();
            
            // TableHistoryに更新履歴を保存
            TableHistory::create([
                'table_name' => 'ＰＣ貸与',
                'target_id' => $pcLoan->id,
                'target_name' => $pcLoan->pc_number,
                'action' => '削除',
                'responder' => Auth::user()->employee_name,
                'compatible_date' => now(),
            ]);

        } catch (Exception $e) {
            Log::channel('error')->alert('ＰＣ貸与テーブルエラー(PcLoanController->destroy)', [$e->getMessage()]);
            return redirect(route('admin.table.pc-loans.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        // タスク一覧ページへリダイレクトし、成功メッセージを表示
        return redirect(route('admin.table.pc-loans.index'))->with('success', '貸与情報が正常に削除されました。');
    }

    private function validatePcLoan(Request $request)
    {
        $rules = [
            'pc_number' => 'required',
            'service_tag' => 'required',
        ];

        $messages = [
            'pc_number.required' => ':attributeは必須項目です。',
            'service_tag.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'pc_number' => 'ＰＣナンバー',
            'service_tag' => 'サービスタグ',
         ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
}
