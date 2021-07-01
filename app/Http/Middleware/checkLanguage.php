<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;

class checkLanguage
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
        if (session('lang')) {
            app()->setLocale(session('lang'));
        } else {
            $lang = Language::where('status', 1)->first();
            if ($lang) {
                app()->setLocale($lang->code);
            }
        }

        return $next($request);
    }
}
