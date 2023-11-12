<?php

namespace App\Clients\Qss;

class Qss
{
    /**
     * @var string
     */
    private ?string $token;

    /**
     * Constructor
     *
     * @param string $token
     */
    public function __construct(string $token = null)
    {
        $this->token = $token;
    }

    /**
     * Handles book endpoints
     *
     * @return Books
     */
    public function books(): Books
    {
        return new Books($this->token);
    }

    /**
     * Handles authors enpoints
     *
     * @return Authors
     */
    public function authors(): Authors
    {
        return new Authors($this->token);
    }

    /**
     * Handles token enpoints
     *
     * @return Token
     */
    public function token(): Token
    {
        return new Token();
    }
}
