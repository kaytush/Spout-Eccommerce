<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\GeneralSettings;
use App\Models\User;
use Illuminate\Http\Request;

class CompleteProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->address == NULL || auth()->user()->gender == NULL || auth()->user()->dob == NULL) {
            return redirect()->route('user.profile');
        }

        return $next($request);
    }
}
