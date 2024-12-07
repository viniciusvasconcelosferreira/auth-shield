<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $token = $request->user()->currentAccessToken();
            $expiration = config('sanctum.expiration');
            
            if ($expiration && $token->created_at->addMinutes($expiration)->isPast()) {
                return response()->json(['message' => 'Token expirado'], 401);
            }
        }

        return $next($request);
    }
}
