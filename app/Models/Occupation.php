<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occupation extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'occupation_id'; // 主キーのカラム名
    public $incrementing = false; // 自動採番OFFにする（重要！）

    protected $fillable = [
        'occupation_id',
        'occupation_name',
    ];

    public function saveOccupation(Request $request)
    {
        $this->occupation_id = $request->input('occupation_id');
        $this->occupation_name = $request->input('occupation_name');
        $this->save();
    }

}
