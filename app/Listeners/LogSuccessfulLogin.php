<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class LogSuccessfulLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;
        Log::channel('login')->info('ログイン成功', [
            'employee_id' => $user->employee_id,
            'employee_name' => $user->employee_name ?? '',
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}
