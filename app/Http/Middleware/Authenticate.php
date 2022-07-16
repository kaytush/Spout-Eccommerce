<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Models\User;
use Carbon\Carbon;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function authenticate($request, array $guards)
    {
    if (empty($guards)) {
    $guards = [null];
    }

    foreach ($guards as $guard) {
        if ($this->auth->guard($guard)->check()) {
        // add the code here
            if (auth()->user()) {
            $user = User::whereId(auth()->user()->id)->update(['online'=> Carbon::now()]);
            }
        return $this->auth->shouldUse($guard);
        }else{
            return route('login');
        }
    }

    $this->unauthenticated($request, $guards);
    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
