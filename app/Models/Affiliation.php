<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Affiliation extends Model
{
    protected $primaryKey = 'affiliation_id'; // 主キーのカラム名
    public $incrementing = false; // 自動採番OFFにする（重要！）
    
    protected $fillable = [
        'affiliation_id',
        'affiliation_name',
        'affiliation_explanation',
    ];
    
    public function saveAffiliation(Request $request)
    {
        $this->affiliation_id = $request->input('affiliation_id');
        $this->affiliation_name = $request->input('affiliation_name');
        $this->affiliation_explanation = $request->input('affiliation_explanation');

        $this->save();
    }
}
