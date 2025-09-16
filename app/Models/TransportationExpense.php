<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request; // Requestクラスをインポート
use Illuminate\Database\Eloquent\SoftDeletes; // SoftDeletesトレイトをインポート
use Illuminate\Support\Facades\Auth;

class TransportationExpense extends Model
{
    protected $casts = [
        'applied_date' => 'date:Y-m-d',
        'use_date' => 'date:Y-m-d',
    ];        
    
    public function saveTransportationExpenses($expenses)
    {
        $processedIds = []; // 処理済みの ID を格納
        foreach ($expenses['use_date'] as $i => $date) {
            $expenseId = $expenses['expense_id'][$i] ?? null;
            if ($expenseId) {
                // 既存行は更新
                $expense = TransportationExpense::find($expenseId);
                $expense->use_date = $date;
                $expense->route_start = $expenses['route_start'][$i];
                $expense->route_end = $expenses['route_end'][$i];
                $expense->amount = $expenses['amount'][$i];
            } else {
                // 新規行は追加
                $expense = new TransportationExpense();
                $expense->employee_id = Auth::user()->employee_id;
                $expense->applied_date = $expenses['applied_date'];
                $expense->use_date = $date;
                $expense->route_start = $expenses['route_start'][$i];
                $expense->route_end = $expenses['route_end'][$i];
                $expense->amount = $expenses['amount'][$i];
            }
            if ($expenses['action'] === '申請'){
                $expense->submitted = 1;
            }
            
            // 登録処理
            $expense->save();
            $processedIds[] = $expenseId;
        }

        // 送信されなかった既存レコードは削除
        TransportationExpense::where('employee_id', Auth::user()->employee_id)
            ->where('applied_date', $expenses['applied_date'])
            ->whereNotIn('id', $processedIds)
            ->delete();
    }

    // EmployeeAccountとのリレーション
    public function EmployeeAccount()
    {
        return $this->belongsTo(EmployeeAccount::class, 'employee_id');
    }
}
