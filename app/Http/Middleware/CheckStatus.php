<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\GeneralSettings;
use App\Models\User;
use Illuminate\Http\Request;

class CheckStatus
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
        $gnl = GeneralSettings::first();
        if($gnl->maintain ==1){
            return redirect()->route('maintain');
        }

       if (auth()->user()){
            if (auth()->user()->status == 0) {
                return redirect()->route('inactive');
            }
            if(auth()->user()->email_verified == 1)
            {
                return $next($request);
            }else{
                return redirect()->route('authorization');
            }

        }else{
            return redirect()->route('login');
        }
    }
}
