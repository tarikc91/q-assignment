<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeImmutable;
use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Clients\Qss\Client as QssClient;
use App\Clients\Qss\Exceptions\RequestException as QssRequestException;

class QssAuthController
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            $response = app(QssClient::class)->getAccessToken($request->email, $request->password);
            $responseBody = json_decode($response->getBody(), true);

            session(['qss_token' => $responseBody['token_key']]);
            session(['qss_token_expires_at' => (new DateTimeImmutable())->modify('+1 day')->format(DateTime::ATOM)]); // token expires in 1 day or 24h
            session(['qss_user' => $responseBody['user']]);

            return redirect()->route('home');
        } catch(QssRequestException $e) {
            if($e->getCode() === 403) {
                session()->flash('error', 'User not found or inactive or password not valid.');
            } else {
                session()->flash('error', 'Something went wrong! Please try again.');
            }

            return redirect()->back();
        }
    }

    public function logout(): RedirectResponse
    {
        session()->flush();

        return redirect()->route('home');
    }
}
