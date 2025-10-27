<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'body',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function saveNotification(Request $request)
    {
        $this->title = $request->input('title');
        $this->body = $request->input('body');
        $this->start_at = $request->input('start_at') ?? now();
        $this->end_at = $request->input('end_at');

        $this->save();
    }

    public function employees()
    {
        return $this->belongsToMany(EmployeeAccount::class, 'notification_employee_account', 'notification_id', 'employee_account_id', 'id', 'employee_id')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    public function readEmployees()
    {
        return $this->belongsToMany(EmployeeAccount::class, 'notification_employee_account', 'notification_id', 'employee_account_id', 'id', 'employee_id');
    }
}
