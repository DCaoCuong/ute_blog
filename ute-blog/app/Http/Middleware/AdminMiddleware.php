<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Admin-only access for user/department management
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!$user->isAdmin()) {
            abort(403, 'Bạn không có quyền truy cập khu vực quản trị. Chỉ Admin mới được phép.');
        }

        return $next($request);
    }
}
