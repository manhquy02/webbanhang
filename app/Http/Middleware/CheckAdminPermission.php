<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$requiredPermission): Response
    {
        
        $user = $request->user();
       if ($requiredPermission === 'edit' && $user->permission_level !== 'edit') {
        abort(403, 'Bạn không có quyền chỉnh sửa');
    }
        
           return $next($request);
        
    }
}
