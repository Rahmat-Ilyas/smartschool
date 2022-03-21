<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard)
    {
        switch ($guard) {
            case 'siswa':
                if (Auth::guard($guard)->check()) {
                    return redirect('user/' . session('level_user'));
                }
                break;
            case 'guru':
                if (Auth::guard($guard)->check()) {
                    return redirect('user/' . session('level_user'));
                }
                break;
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    $user = Auth::guard($guard)->user();
                    return redirect('admin/' . $user->is_skl->keyword);
                    // return redirect()->route('admin.home');
                }
                break;
        }

        return $next($request);
    }
}
