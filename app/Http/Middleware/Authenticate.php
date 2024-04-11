<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
//use Illuminate\Support\Facades\Route; //読み込む
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{

    protected $user_route = 'user.login'; //ユーザーのログイン画面。　RouteServiceProviderで設定した ->as('user.')からきてる
    protected $owner_route = 'owner.login'; //オーナーのログイン画面。　RouteServiceProviderで設定した ->as('owner.')からきてる
    protected $admin_route = 'admin.login'; //adminのログイン画面。　RouteServiceProviderで設定した ->as('admin.')からきてる


    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (! $request->expectsJson()) {
        //     //return route('login');

            //オーナー関連のファイルでログインしてなかったら、オーナーのログイン画面に飛ぶ
            if(Route::is('owner.*')){
                return route($this->owner_route);
            } elseif(Route::is('admin.*')){ //admin関連のファイルでログインしてなかったら、adminのログイン画面に飛ぶ
                return route($this->admin_route);
            } else { //ownerとadminい以外の関連のファイルでログインしていなかったら、userのログイン画面に飛ぶ
                return route($this->user_route);
            }

    }
}
