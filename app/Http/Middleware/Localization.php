<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        }
        return $next($request);
    }
}
