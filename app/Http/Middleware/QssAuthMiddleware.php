<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\QssAuthenticator;
use Symfony\Component\HttpFoundation\Response;

class QssAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        QssAuthenticator::setUser();

        if(!QssAuthenticator::check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
