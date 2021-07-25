<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == $role) {
                return $next($request);
            } else {
                return redirect()->route('admin.index.index')->with('error', 'Bạn không có quyền thực hiện chức năng này');
            }
        } else {
            return redirect('auth.auth.login');
        }
    }
}
