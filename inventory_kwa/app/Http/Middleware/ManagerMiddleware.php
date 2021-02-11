<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ManagerMiddleware
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
    	$level = session()->get('level');
    	if($level == '100') {
	        return redirect('dashboard');
    	}
    	else if($level == '101') {
	        return redirect('dashboard');
    	}
    	else if($level == '102') {
	        return $next($request);
    	}
    }
}