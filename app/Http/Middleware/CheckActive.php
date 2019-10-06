<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class CheckActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (!Auth::user()->active) {
              return redirect('/')->with('nonActive', 'Account is not active');
            }
          }
          
        return $next($request);
    }
}
