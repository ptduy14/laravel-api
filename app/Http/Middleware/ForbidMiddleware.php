<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForbidMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $scope): Response
    {
        $user = $request->user();

        if ($user->tokenCan($scope)) {
            return response()->json(['message' => 'Tokens are not allowed to access this resource'], 401);
        }

        return $next($request);
    }
}
