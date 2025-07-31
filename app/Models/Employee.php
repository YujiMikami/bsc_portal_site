<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Department;
use App\Models\Affiliation;
use App\Models\EmployeeClass;
use App\Models\EmployeePost;
use App\Models\Occupation;
use Illuminate\Support\Facades\Auth;

class Employee extends Authenticatable
{
    protected $primaryKey = 'employee_id'; // 主キーのカラム名
    public $incrementing = false; // 自動採番OFFにする（重要！）

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'employee_id',
        'employee_name',
        'employee_name_furigana',
        'gender',
        'employee_class_id',
        'department_id',
        'affiliation_id',
        'occupation_id',
        'birth_date',
        'hire_date',
        'post_code',
        'prefecture',
        'municipalitie',
        'address_2',
        'address_3',
        'phone_number',
        'mobile_phone_number',
        'final_academic_date',
        'final_academic',
        'work_history_1_date',
        'work_history_1',
        'work_history_2_date',
        'work_history_2',
        'work_history_3_date',
        'work_history_3',
        'work_history_4_date',
        'work_history_4',
        'work_history_5_date',
        'work_history_5',
        'work_history_6_date',
        'work_history_6',
        'work_history_7_date',
        'work_history_7',
        'work_history_8_date',
        'work_history_8',
        'work_history_9_date',
        'work_history_9',
        'work_history_10_date',
        'work_history_10',
        'license_1',
        'license_2',
        'license_3',
        'license_4',
        'license_5',
        'social_insurance_Applicable_date',
        'health_insurance',
        'basic_pension_number',
        'welfare_pension_number',
        'health_insurance_basic_reward_monthly_fee',
        'health_insurance_grade',
        'pension_basic_reward_monthly_fee',
        'pension_grade',
        'employment_applicable_date',
        'applicable_insurance_number',
        'employee_class_updated_at',
        'retirement_date',
        'retirement_reason',
        'note',
        'password',
        'portal_role',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function saveEmployee(Request $request)
    {
        $this->fill($request->all());
        
        if (!$this->exists) {
            $this->password = bcrypt('bsc' . $this->employee_id);
        } // パスワードだけ個別処理
        $this->updated_by = Auth::user()->employee_name;
        
        $this->final_academic_date = $request->final_academic_date ? $request->final_academic_date . '-01' : null;
        $this->work_history_1_date = $request->work_history_1_date ? $request->work_history_1_date . '-01' : null;
        $this->work_history_2_date = $request->work_history_2_date ? $request->work_history_2_date . '-01' : null;
        $this->work_history_3_date = $request->work_history_3_date ? $request->work_history_3_date . '-01' : null;
        $this->work_history_4_date = $request->work_history_4_date ? $request->work_history_4_date . '-01' : null;
        $this->work_history_5_date = $request->work_history_5_date ? $request->work_history_5_date . '-01' : null;
        $this->work_history_6_date = $request->work_history_6_date ? $request->work_history_6_date . '-01' : null;
        $this->work_history_7_date = $request->work_history_7_date ? $request->work_history_7_date . '-01' : null;
        $this->work_history_8_date = $request->work_history_8_date ? $request->work_history_8_date . '-01' : null;
        $this->work_history_9_date = $request->work_history_9_date ? $request->work_history_9_date . '-01' : null;
        $this->work_history_10_date = $request->work_history_10_date ? $request->work_history_10_date . '-01' : null;

        if ($this->isDirty('employee_class_id')) {
            $this->employee_class_updated_at = now();
        }

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
}
