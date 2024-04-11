<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
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

        $this->ensureIsNotRateLimited();


        if($this->routeIs('owner.*')){ //オーナーのログインフォームからきたら、
            $guard = 'owners'; //ガードの設定をownersに変える
        } elseif($this->routeIs('admin.*')){
            $guard = 'admin';
        } else {
            $guard = 'users';
        }


        if (! Auth::guard($guard)->attempt($this->only('email', 'password'), $this->boolean('remember'))) { //★guard($guard)->を追記
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
