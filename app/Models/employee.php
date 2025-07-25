<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'name',
        'email',
        'password',
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
        // $request オブジェクトから直接データを取得し、モデルのプロパティに割り当てる
        $this->employee_id = $request->input('employee_id');
        $this->employee_name = $request->input('employee_name');
        $this->role = $request->input('portal_role');
        $this->password = 'bsc' . $request->input('employee_id');
        // 登録処理
        $this->save();
    }

    public function isAdmin(): bool
    {
        // ここでは、ユーザーテーブルに 'role' カラムがあり、
        // その値が 'admin' の場合に管理者を意味すると仮定しています。
        return $this->role === 1;

        // もしユーザーIDが1のユーザーを管理者とする場合は、以下のように記述できます。
        // return $this->id === 1;
    }
}
