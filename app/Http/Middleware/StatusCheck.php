<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StatusCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->status == 'deactivated'){
            auth()->logout();
            return redirect()->route('login')->with('failed', 'Account was deactivated');
        }
        return $next($request);
    }
}
