<?php

namespace App\Http\Middleware;

use Closure;
use App\Entrepreneur;

class CheckApi
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
        $entrepreneur  = Entrepreneur::where('telephone', $request->entrepreneurTel)->where('status', 1)->first();
        if($entrepreneur) {
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
