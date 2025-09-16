<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCache
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        if (method_exists($response, 'header')) {
            $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                     ->header('Pragma', 'no-cache')
                     ->header('Expires', '0');
        }

        return $response;
    }
}
