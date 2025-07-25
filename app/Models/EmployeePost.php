<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EmployeePost extends Model
{
    protected $primaryKey = 'employee_post_id'; // 主キーのカラム名
    public $incrementing = false; // 自動採番OFFにする（重要！）

    public function saveEmployeePost(Request $request)
    {
        $this->employee_post_id = $request->input('employee_post_id');
        $this->employee_post_name = $request->input('employee_post_name');

        $this->save();
    }

}
