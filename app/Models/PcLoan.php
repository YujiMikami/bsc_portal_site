<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PcLoan extends Model
{
    protected $fillable = [
        'pc_number',
        'service_tag',
        'os',
        'pc_name',
        'pin',
        'office',
        'office_lisence',
        'security_soft',
        'bios_pass',
        'foticlient_account',
        'foticlient_pass',
        'employee_id',
        'employee_name',
        'wifi',
        'ms_account',
        'ms_pass',
    ];

    protected $casts = [];

    public function savePcLoan(Request $request)
    {
        $this->pc_number = $request->input('pc_number');
        $this->service_tag = $request->input('service_tag');
        $this->os = $request->input('os');
        $this->pc_name = $request->input('pc_name');
        $this->pin = $request->input('pin');
        $this->office = $request->input('office');
        $this->office_lisence = $request->input('office_lisence');
        $this->security_soft = $request->input('security_soft');
        $this->bios_pass = $request->input('bios_pass');
        $this->foticlient_account = $request->input('foticlient_account');
        $this->foticlient_pass = $request->input('foticlient_pass');
        $this->employee_id = $request->input('employee_id');
        $this->employee_name = $request->input('employee_name');
        $this->wifi = $request->input('wifi');
        $this->ms_account = $request->input('ms_account');
        $this->ms_pass = $request->input('ms_pass');
        $this->updated_by = Auth::user()->employee_name;
        $this->save();
    }
}
