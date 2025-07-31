<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'department_id'; // 主キーのカラム名
    public $incrementing = false; // 自動採番OFFにする（重要！）

    protected $fillable = [
        'department_id',
        'department_name',
        'department_explanation',
    ];


    public function saveDepartment(Request $request)
    {
        $this->department_id = $request->input('department_id');
        $this->department_name = $request->input('department_name');
        $this->department_explanation = $request->input('department_explanation');
        
        $this->save();
    }

}
