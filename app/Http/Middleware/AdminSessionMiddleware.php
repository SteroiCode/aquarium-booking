<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminSessionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Change session cookie name BEFORE session starts
        config(['session.cookie' => 'aquarium_admin_session']);

        return $next($request);
    }
}
