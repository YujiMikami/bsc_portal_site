<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class EmployeeAccount extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'employee_accounts';
    protected $primaryKey = 'employee_id'; // 主キーのカラム名

    protected $fillable = [
        'employee_id',
        'employee_name',
        'employee_name_furigana',
        'employee_class_id',
        'department_id',
        'affiliation_id',
        'employee_post_id',
        'occupation_id',
        //'email',
        'password',
        'portal_role',
    ];

    public function saveEmployeeAccount(Request $request)
    {
        $this->fill($request->all());
        
        if (!$this->exists) {
            $this->password = bcrypt('bsc' . $this->employee_id);
        } // パスワードだけ個別処理
        
        $this->employee_id = $request->input('employee_id');
        $this->employee_name = $request->input('employee_name');
        $this->employee_name_furigana = $request->input('employee_name_furigana');
        $this->employee_class_id = $request->input('employee_class_id');
        $this->department_id = $request->input('department_id');
        $this->affiliation_id = $request->input('affiliation_id');
        $this->employee_post_id = $request->input('employee_post_id');
        $this->occupation_id = $request->input('occupation_id');
        //$this->email = $request->input('email');
        //$this->password = $request->input('password');
        $this->portal_role = $request->input('portal_role');

        $this->save();
    }


    public function isAdmin(): bool
    {
        // ここでは、ユーザーテーブルに 'role' カラムがあり、
        // その値が 'admin' の場合に管理者を意味すると仮定しています。
        return $this->portal_role === 1;

        // もしユーザーIDが1のユーザーを管理者とする場合は、以下のように記述できます。
        // return $this->id === 1;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function affiliation()
    {
        return $this->belongsTo(Affiliation::class, 'affiliation_id', 'affiliation_id');
    }

    public function employeeClass()
    {
        return $this->belongsTo(EmployeeClass::class, 'employee_class_id', 'employee_class_id');
    }

    public function employeePost()
    {
        return $this->belongsTo(EmployeePost::class, 'employee_post_id', 'employee_post_id');
    }
    
    public function Occupation()
    {
        return $this->belongsTo(Occupation::class, 'occupation_id', 'occupation_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */    
    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_employee_account', 'employee_account_id', 'notification_id', 'employee_id', 'id')
                    ->withPivot('read_at')
                    ->withTimestamps();
    }
}
