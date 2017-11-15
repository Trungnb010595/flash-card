<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = $request->user();
        $route_name = Route::currentRouteName();

        //ktra đăng nhập
        if (!Auth::check()) {
            dflash('Bạn cần phải đăng nhập hoặc bạn không có quyền truy cập','danger');
            return redirect()->route('admin.login-view');
        }

        if ($auth->can($route_name)) {
            return $next($request);
        }

        dflash('You don\'t have permission to access this page.','warning');
        return back();
    }
}
