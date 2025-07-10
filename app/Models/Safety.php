<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request; // Requestクラスをインポート
use Illuminate\Database\Eloquent\SoftDeletes; // SoftDeletesトレイトをインポート
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Safety extends Model
{
    use SoftDeletes; // SoftDeletesトレイトを使用するよう追加
    public function saveSafety(Request $request)
    {
        // $request オブジェクトから直接データを取得し、モデルのプロパティに割り当てる
        $this->post_user_id = $request->input('post_user_id');
        $this->post_user_name = $request->input('safety_post_user');
        $this->safety_status = $request->input('safety_status');
        $this->injury_status = $request->input('injury_status');
        $this->can_work = $request->input('can_work');

        
        
        // 登録処理
        $this->save();
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
