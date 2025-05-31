<?php

namespace App\Http\Middleware;

use App\EnumRoleName;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class permissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , $permission)
    {

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        if (in_array($permission , ['view.admins' , 'view.users']) && !$user->hasRole(EnumRoleName::ADMIN)) {
            abort(403);
        }

        if (!$user->hasPermission($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
