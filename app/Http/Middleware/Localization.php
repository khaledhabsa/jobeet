<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
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

        $local = 'en';
        if($request->hasHeader('Localization')){
            $local = $request->header('Localization');
        }

        app()->setLocale($local);

        return $next($request);
    }
}
