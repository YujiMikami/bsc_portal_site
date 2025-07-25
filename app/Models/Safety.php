<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request; // Requestクラスをインポート
use Illuminate\Database\Eloquent\SoftDeletes; // SoftDeletesトレイトをインポート
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Safety extends Model
{
    use SoftDeletes; // SoftDeletesトレイトを使用するよう追加
    public function saveSafety(Request $request)
    {
        // $request オブジェクトから直接データを取得し、モデルのプロパティに割り当てる
        $this->safety_employee_id = Auth::user()->employee_id;
        $this->safety_employee_name = Auth::user()->employee_name;
        $this->safety_status = $request->input('safety_status');
        $this->injury_status = $request->input('injury_status');
        $this->can_work = $request->input('can_work');

        
        
        // 登録処理
        $this->save();
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
