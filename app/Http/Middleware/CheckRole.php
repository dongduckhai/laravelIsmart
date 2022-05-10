<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();
        if($user->role->name != $role)
            return redirect('/admin')->with('alert','Chỉ quản trị viên mới có quyền thực hiện tác vụ này');
        return $next($request);
    }
}
