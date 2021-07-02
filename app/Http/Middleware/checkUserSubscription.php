<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkUserSubscription
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
        $user = User::where('id',Auth::id())->first();

        if ($user->subscriptions->isEmpty()) {
            return redirect()->route('user.plan')->with('info','Please subscribe a plan first');
        }

        return $next($request);
    }
}
