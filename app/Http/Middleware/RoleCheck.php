<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ログイン済みかチェック
        if (!Auth::check()) {
            abort(403, 'ログインが必要です');
        }

        // 例: roleが'admin'かどうか
        if (Auth::user()->portal_role !== 1) {
            abort(403, 'このページにアクセスできません');
        }

        return $next($request);
    
    }
}
