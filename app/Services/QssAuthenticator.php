<?php

namespace App\Services;

use DateTime;
use DateTimeImmutable;
use App\Models\AuthUser;
use App\Clients\Qss\Client as QssClient;
use App\Clients\Qss\Exceptions\RequestException as QssRequestException;
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
    public static function attemptLogin(string $email, string $password): bool|AuthUser
    {
        try {
            $response = resolve(QssClient::class)->getAccessToken($email, $password);
            
            static::login($response['token'], $response['user']);

            return resolve(AuthUser::class);
        } catch(QssRequestException $e) {
            if($e->getCode() === 403) {
                return ['error' => 'User not found or inactive or password not valid.'];
            } else {
                return ['error' => 'Something went wrong! Please try again.'];
            }
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
     * @return void
     */
    private static function login(string $token, array $user): void
    {
        session([
            'qss_token' => $token,
            'qss_user' => $user,
            'qss_token_expires_at' => static::getTokenExpirationDate()
        ]);

        static::setAuthUser($user);
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
     * Sets auth user
     *
     * @param array $user
     * @return void
     */
    public static function setAuthUser(array $user): void
    {
        $authUser = resolve(AuthUser::class);
        $authUser->setDataFromTransformer(new QssAuthUserTransformer($user));
        $authUser->setLoggedIn(true);
    }
}
