<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Middlewares\RoleMiddleware;

class JsonResponseMiddleware extends RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $response = parent::handle($request, $next, ...$roles);

        // Kiểm tra xem response có là một instance của \Illuminate\Http\RedirectResponse hay không
        // Nếu có, thì chuyển đổi thành JSON response
        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            $response = response()->json(['message' => 'Unauthorized'], 401);
        }

        return $response;
    }
}
