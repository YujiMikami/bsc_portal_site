<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request; // Requestクラスをインポート
use Illuminate\Database\Eloquent\SoftDeletes; // SoftDeletesトレイトをインポート
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class PaidRequest extends Model
{
    use SoftDeletes; // SoftDeletesトレイトを使用するよう追加
    public function savePaidRequest(Request $request)
    {
        // $request オブジェクトから直接データを取得し、モデルのプロパティに割り当てる
        $this->application_date = $request->input('application_date');
        $this->employee_id = $request->input('employee_id');
        $this->affiliation = $request->input('affiliation');
        $this->employee_name = $request->input('employee_name');
        $this->start_date = $request->input('start_date');
        $this->end_date = $request->input('end_date');
        $this->days = $request->input('days');
        $this->distinction = $request->input('distinction');
        $this->reason = $request->input('reason');
        $this->note = $request->input('note');
        
        // 登録処理
        $this->save();
    }
}
