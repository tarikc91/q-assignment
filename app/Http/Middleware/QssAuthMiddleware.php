<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use App\Models\AuthUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Transformers\Qss\AuthUserTransformer as QssAuthUserTransformer;

class QssAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = session('qss_token');
        $tokenExpiresAt = session('qss_token_expires_at');
        $user = session('qss_user');

        if($token && $tokenExpiresAt && $user) {
            $tokenExpiresAt = new DateTime($tokenExpiresAt);
            $now = new DateTime();

            if($now < $tokenExpiresAt) {
                // Create a new AuthUser, which is a singleton, using the Laravel service container
                // This object represents the logged in user and it will be available
                // to all routes that are protected with this middleware
                $authUser = app(AuthUser::class);
                $authUser->setDataFromTransformer(new QssAuthUserTransformer($user));
                $authUser->setLoggedIn(true);

                return $next($request);
            }
        }

        return redirect()->route('login');
    }
}
