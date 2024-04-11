<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{

    //config/auth.php内のファイル添付
    // 'guards' => [
    //     'web' => [
    //         'driver' => 'session',
    //         'provider' => 'users',
    //     ],

    //     //users
    //     'users' => [
    //         'driver' => 'session',
    //         'provider' => 'users',
    //     ],

    //     //owners
    //     'owners' => [
    //         'driver' => 'session',
    //         'provider' => 'owners',
    //     ],

    //     //admin
    //     'admin' => [
    //         'driver' => 'session',
    //         'provider' => 'admin',
    //     ],
    // ],

    private const GUARD_USER = 'users'; //config/auth.php内のファイルの、各guards内を一致させる必要あり。
    private const GUARD_OWNER = 'owners';
    private const GUARD_ADMIN = 'admin';


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // $guards = empty($guards) ? [null] : $guards;

        // foreach ($guards as $guard) {
        //     if (Auth::guard($guard)->check()) {
        //         return redirect(RouteServiceProvider::HOME);
        //     }
        // }

        //user
        if(Auth::guard(self::GUARD_USER)->check() && $request->routeIs('user.*')){
            return redirect(RouteServiceProvider::HOME);
        }

        //owner
        if(Auth::guard(self::GUARD_OWNER)->check() && $request->routeIs('owner.*')){
            return redirect(RouteServiceProvider::OWNER_HOME); //OWNER_HOMEは、RouteServiceProviderで設定したもの
        }

        //admin
        if(Auth::guard(self::GUARD_ADMIN)->check() && $request->routeIs('admin.*')){
            return redirect(RouteServiceProvider::ADMIN_HOME);
        }


        return $next($request);
    }
}
