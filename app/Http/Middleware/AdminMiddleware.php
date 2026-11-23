<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('admin.login')->with('message', 'Please login as admin to access this area.');
        }

        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('admin.login')->with('message', 'Please login as admin to access this area.');
        }

        return $next($request);
    }
}
