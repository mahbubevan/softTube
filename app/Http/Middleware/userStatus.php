<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class userStatus
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
        if (auth()->user()->status==0) {
            return redirect()->route('logout')->with('error','Your account has been deactivated. Please Contact');
        }

        if (auth()->user()->email_verified_at==null) {
            return redirect()->route('user.authorize.form')->with('info','Please verify your email');
        }

        return $next($request);
    }
}
