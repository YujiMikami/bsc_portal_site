<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $primaryKey = 'department_id'; // 主キーのカラム名
    public $incrementing = false; // 自動採番OFFにする（重要！）

    public function saveDepartment(Request $request)
    {
        $this->department_id = $request->input('department_id');
        $this->department_name = $request->input('department_name');
        $this->department_explanation = $request->input('department_explanation');
        
        $this->save();
    }

}
