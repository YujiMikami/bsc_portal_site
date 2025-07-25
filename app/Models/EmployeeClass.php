<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EmployeeClass extends Model
{
    protected $primaryKey = 'employee_class_id'; // 主キーのカラム名
    public $incrementing = false; // 自動採番OFFにする（重要！）

    public function saveEmployeeClass(Request $request)
    {
        $this->employee_class_id = $request->input('employee_class_id');
        $this->employee_class_name = $request->input('employee_class_name');
        $this->save();
    }

}
