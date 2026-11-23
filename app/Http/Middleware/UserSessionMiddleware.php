<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserSessionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        config(['session.cookie' => 'aquarium_user_session']);

        return $next($request);
    }
}
