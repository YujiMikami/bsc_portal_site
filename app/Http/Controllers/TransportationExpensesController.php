<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransportationExpense;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TransportationExpensesController extends Controller
{
    public function index()
    {
        $query = TransportationExpense::with('EmployeeAccount');
        if (Auth::user()->portal_role == 1) {       // 管理者だったら
            $query->where('submitted', 1)            // 申請済みで
                ->whereNotNull('approver')          // 承認済みで
                ->whereNull('recipient');           // 未受理のレコード
        } elseif (Auth::user()->employee_post_id == 4) {    // 上司だったら
            $query->where('submitted', 1)                    // 申請済みで
                ->whereNull('approver');                    // 未承認のレコード
        } else {                                                        // 申請者だったら
            $query->where('employee_id', Auth::user()->employee_id);    // 自分の申請のレコード
        }
        $expensesByDate = $query->orderBy('id', 'desc')
            ->get()
            ->groupBy(function($item) {
                return $item->applied_date->format('Y-m-d') . '_' . $item->employee_id; // 申請日と社員番号でグループ化
            }
        );
        return view('public.reports.transportation-expenses.index', compact('expensesByDate'));
    }

    public function create()
    {
        return view('public.reports.transportation-expenses.create');
    }
    
    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validateTransportationExpenses($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // 編集フォームのルートにリダイレクト
            return redirect(route('public.reports.transportation-expenses.create'))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        $validated = $validator->validated();
        $expenses = array_merge(
            $validated,
            [
                'expense_id' => $request->input('expense_id', []),
                'action' => $request->input('action'),
            ]

        );
        try {
            $expense = new TransportationExpense();
            $expense->saveTransportationExpenses($expenses);

        } catch (Exception $e) {
            Log::channel('error')->alert('交通費申請エラー(TransportationExpenses->store)', [$e->getMessage()]);
            return redirect()->route('public.reports.transportation-expenses.index')->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }
        
        if ($expenses['action'] == '申請') {
            $message = '交通費を申請しました。';
        } else {
            $message = '交通費申請を保存しました。';

        }
        return redirect()->route('public.reports.transportation-expenses.index')->with('success', $message);
    }

    public function show($id, $date)
    {
        try {
            $query = TransportationExpense::where('employee_id', $id)
                ->where('applied_date', $date);
            if (Auth::user()->portal_role == 1) {
                $query->where('submitted',1)
                ->whereNotNull('approver')
                ->whereNull('recipient');
            } elseif (Auth::user()->employee_post_id == 4) {
                $query->where('submitted',1)
                ->whereNull('approver');
            }
            $transportationExpenses = $query->get();

            if ($transportationExpenses->first()->employee_id !== Auth::user()->employee_id && (Auth::user()->portal_role !== 1 && Auth::user()->employee_post_id !== 4)) {
                return redirect(route('public.reports.transportation-expenses.index'))->with('error', '他の申請は閲覧できません。');
            }

        } catch (Exception $e) {
            Log::channel('error')->alert('交通費申請エラー(TransportationExpenses->show)', [$e->getMessage()]);
            return redirect(route('public.reports.transportation-expenses.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }
        return view('public.reports.transportation-expenses.show', compact('transportationExpenses'));
    }
    public function edit($id, $date) 
    {
        try {
            $query = TransportationExpense::where('employee_id', $id)
                ->where('applied_date', $date);
            $transportationExpenses = $query->get();
        if ($transportationExpenses->first()->employee_id !== Auth::user()->employee_id) {
            return redirect(route('public.reports.transportation-expenses.index'))->with('error', '他の申請は更新できません。');
        }
        if ($transportationExpenses->first()->approver !== NULL) {
            return redirect(route('public.reports.transportation-expenses.index'))->with('error', 'すでに承認されています。');
        }
        } catch (Exception $e) {
            Log::channel('error')->alert('交通費申請エラー(TransportationExpenses->edit)', [$e->getMessage()]);
            return redirect(route('public.reports.transportation-expenses.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }
        return view('public.reports.transportation-expenses.create', compact('transportationExpenses'));
    }

    public function update(Request $request, $id, $date)
    {
        // バリデーション
        $validator = $this->validateTransportationExpenses($request);
        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // 編集フォームのルートにリダイレクト
            return redirect(route('public.reports.transportation-expenses.edit', ['id' => $id, 'date' => $date]))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }
        $validated = $validator->validated();
        $expenses = array_merge(
            $validated,
            [
                'expense_id' => $request->input('expense_id', []), // バリデートなしでも取得
                'action' => $request->input('action'),
            ]
        );
        try {
            $expense = new TransportationExpense();
            $expense->saveTransportationExpenses($expenses);
        } catch (Exception $e) {
            Log::channel('error')->alert('交通費申請エラー(TransportationExpenses->update)', [$e->getMessage()]);
            return redirect(route('public.reports.transportation-expenses.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('public.reports.transportation-expenses.index'))->with('success', '交通費申請を正常に更新しました。');
    }

    public function destroy($id, $date)
    {
        try {
            $query = TransportationExpense::where('employee_id', $id)
                ->where('applied_date', $date);
                $transportationExpenses = $query->get();
            foreach ($transportationExpenses as $expense) {
                if ($expense->approver !== NULL) {
                 redirect(route('public.reports.transportation-expenses.index'))->with('error', 'すでに承認されています。');
                }
                $expense->delete();
            }
        } catch (Exception $e) {
            Log::channel('error')->alert('交通費申請エラー(TransportationExpenses->destroy)', [$e->getMessage()]);
            return redirect(route('public.reports.transportation-expenses.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('public.reports.transportation-expenses.index'))->with('success', '交通費申請を削除しました。');
    }

    public function approval($id, $date)
    {
        try {
            TransportationExpense::where('employee_id', $id)
                ->where('applied_date', $date)
                ->where('submitted', 1)
                ->whereNull('approver')
                ->update([
                    'approver' => Auth::user()->employee_name,
                ]);
        
        } catch (Exception $e) {
            Log::channel('error')->alert('交通費申請エラー(TransportationExpenses->approval)', [$e->getMessage()]);
            return redirect(route('public.reports.transportation-expenses.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect()->route('public.reports.transportation-expenses.index')->with('success', '申請を承認しました。');

    }

    public function acceptance($id, $date)
    {
        try {
            TransportationExpense::where('employee_id', $id)
                ->where('applied_date', $date)
                ->where('submitted', 1)
                ->whereNotNull('approver')
                ->whereNull('recipient')
                ->update([
                    'recipient' => Auth::user()->employee_name,
                ]);
        
        } catch (Exception $e) {
            Log::channel('error')->alert('交通費申請エラー(TransportationExpenses->acceptance)', [$e->getMessage()]);
            return redirect(route('public.reports.transportation-expenses.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('public.reports.transportation-expenses.index'))->with('success', '交通費申請を受理しました。');
    }

    private function validateTransportationExpenses(Request $request)
    {
        $rules = [
            'applied_date' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $employeeId = Auth::user()->employee_id;
                    // 申請済みの日付と重複したらエラー
                    $existsToAppry = TransportationExpense::where('employee_id', $employeeId)
                        ->whereDate('applied_date', $value)
                        ->where('submitted', 1)
                        ->exists();

                    if ($existsToAppry) {
                        $fail('この申請日はすでに申請済みです。');
                    }

                    // 申請時のみ未申請の日付と重複したらエラー
                    if ($request->input('action') === '申請') {
                        $existsToSave = TransportationExpense::where('employee_id', $employeeId)
                            ->whereDate('applied_date', $value)
                            ->where('submitted', NULL)
                            ->exists();

                        if ($existsToSave) {
                            $fail('この申請日には未申請のデータが存在します。');
                        }
                    }
                }
            ],
            'use_date.*' => 'required',
            'route_start.*' => 'required',
            'route_end.*' => 'required',
            'amount.*' => 'required|integer|min:0',
        ];

        $messages = [
            'applied_date.required' => ':attributeは必須項目です。',
            'use_date.*.required' => ':attributeは必須項目です。',
            'route_start.*.required' => ':attributeは必須項目です。',
            'route_end.*.required' => ':attributeは必須項目です。',
            'amount.*.required' => ':attributeは必須項目です。',
            'amount.*.integer' => ':attributeは数字のみ入力して下さい。',
            'amount.*.min' => ':attributeは０以上で入力して下さい。',
        ];

        $attributes = [
            'applied_date' => '申請日',
            'use_date.*' => '利用日',
            'route_start.*' => '始点',
            'route_end.*' => '終点',
            'amount.*' => '金額',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
}