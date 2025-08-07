<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePost extends Model
{
    protected $primaryKey = 'employee_post_id'; // 主キーのカラム名
    public $incrementing = false; // 自動採番OFFにする（重要！）

    protected $fillable = [
        'employee_post_id',
        'employee_post_name',
    ];

    public function saveEmployeePost(Request $request)
    {
        $this->employee_post_id = $request->input('employee_post_id');
        $this->employee_post_name = $request->input('employee_post_name');

        $this->save();
    }

}
