<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Middlewares\RoleMiddleware;
use function GuzzleHttp\json_encode;

class ExtendedRoleMiddleware extends RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {   
         $roles = is_array($role)
             ? $role
             : explode('|', $role);

         if (! $request->auth->hasAnyRole($roles)) {
            return response()->json([
                'message' => 'You are not allowed to access this page!'
            ], 400);
         }

        return $next($request);
    }
}
