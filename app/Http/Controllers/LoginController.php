<?php

namespace App\Http\Controllers;

use App\Models\AuthUser;
use App\Services\QssAuthenticator;
use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;

class LoginController
{
    /**
     * Returns login view
     *
     * @return View
     */
    public function show(): View
    {
        return view('auth.login');
    }

    /**
     * Logs user in
     *
     * @param LoginRequest $request
     * @return Response
     */
    public function login(LoginRequest $request): Response
    {
        $result = QssAuthenticator::attemptLogin($request->email, $request->password);

        if($result instanceof AuthUser) {
            return redirect()->route('home');
        }

        return redirect()->back()->with('error', $result['error']);
    }

    /**
     * Logs user out
     *
     * @return Response
     */
    public function logout(): Response
    {
        QssAuthenticator::logout();

        return redirect()->route('home');
    }
}
