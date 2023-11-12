<?php

namespace App\Clients\Qss;

use Psr\Http\Message\ResponseInterface;

class Token extends Endpoint
{
    /**
     * Gets acces token
     *
     * @param string $email
     * @param string $password
     * @return ResponseInterface
     */
    public function get(string $email, string $password): ResponseInterface
    {
        return $this->request('POST', 'token', [], [
            'email' => $email,
            'password' => $password
        ]);
    }
}
