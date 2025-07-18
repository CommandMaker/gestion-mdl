<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUserAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('web')->user() !== null && auth('web')->user()->is_admin) {
            return $next($request);
        }

        return response()->json([
            'status' => 'ok',
            'message' => 'unauthorized.',
        ], 403);
    }
}
