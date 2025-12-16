<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentManagerMiddleware
{
    /**
     * Handle an incoming request.
     * Content Manager ONLY - for post/event management
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Only Content Manager can access (NOT Admin)
        if (!$user->isContentManager()) {
            abort(403, 'Bạn không có quyền truy cập khu vực quản lý nội dung. Chỉ Content Manager mới được phép.');
        }

        return $next($request);
    }
}
