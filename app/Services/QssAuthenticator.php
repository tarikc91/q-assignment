<?php

namespace App\Services;

use DateTime;
use DateTimeImmutable;
use App\Models\AuthUser;
use App\Clients\Qss\Qss;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Transformers\Qss\AuthUserTransformer as QssAuthUserTransformer;

class QssAuthenticator
{
    /**
     * Attempts to login the user
     *
     * @param string $email
     * @param string $password
     * @return boolean|AuthUser
     */
    public static function attemptLogin(string $email, string $password): array|AuthUser
    {
        try {
            $response = resolve(Qss::class)->token()->get($email, $password);

            $responseBody = json_decode($response->getBody(), true);

            return static::login($responseBody['token_key'], $responseBody['user']);
        } catch(HttpException $exception) {
            if($exception->getStatusCode() === 403) {
                return ['error' => 'User not found or inactive or password not valid.'];
            }

            throw $exception;
        }
    }

    /**
     * Logsout the user
     *
     * @return void
     */
    public static function logout(): void
    {
        session()->flush();
        session()->regenerate($destroy = true);
    }

    /**
     * Logs in the user by setting the session and the user
     *
     * @param string $token
     * @param array $user
     * @return AuthUser
     */
    private static function login(string $token, array $user): AuthUser
    {
        session([
            'qss_user' => $user,
            'qss_token' => $token,
            'qss_token_expires_at' => static::getTokenExpirationDate()
        ]);

        return static::createAuthUser($user);
    }

    /**
     * Returns a expiration datetime string
     *
     * @return string
     */
    private static function getTokenExpirationDate(): string
    {
        return (new DateTimeImmutable())
            ->modify('+1 day')
            ->format(DateTime::ATOM);
    }

    /**
     * Creates an authUser
     *
     * @param array $user
     * @return AuthUser
     */
    public static function createAuthUser(array $user): AuthUser
    {
        $authUser = resolve(AuthUser::class);

        $authUser->setDataFromTransformer(new QssAuthUserTransformer($user));

        $authUser->setLoggedIn(true);

        return $authUser;
    }

    /**
     * Returns auth user
     *
     * @return AuthUser|null
     */
    public static function user(): ?AuthUser
    {
        $authUser = resolve(AuthUser::class);

        if(!$authUser->isLoggedIn()) {
            return null;
        }

        return $authUser;
    }

    /**
     * Check if the user is logged in
     *
     * @return boolean
     */
    public static function check(): bool
    {
        return (bool) static::user();
    }

    /**
     * Sets the logged in user
     *
     * @return void
     */
    public static function setUser(): void
    {
        if(
            session('qss_user') &&
            session('qss_token') &&
            session('qss_token_expires_at') &&
            now() < new DateTime(session('qss_token_expires_at'))
        ) {
            static::createAuthUser(session('qss_user'));
        }
    }
}
