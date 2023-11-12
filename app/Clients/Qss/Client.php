<?php

namespace App\Clients\Qss;

use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Client as GuzzleHttpClient;

class Client extends GuzzleHttpClient
{
    private const BASE_PATH = 'https://symfony-skeleton.q-tests.com/api/v2/';

    /**
     * @var string|null
     */
    private ?string $token;

    /**
     * Constructor
     *
     * @param string|null $token
     */
    public function __construct(string $token = null)
    {
        $this->token = $token;

        parent::__construct([
            'base_uri' => self::BASE_PATH,
            'handler' => $this->configureHandler()
        ]);
    }

    /**
     * Configures a handler stack
     *
     * @return HandlerStack
     */
    private function configureHandler(): HandlerStack
    {
        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());

        $stack->push(Middleware::mapRequest(function (RequestInterface $request) {
            $request = $request->withHeader('Content-Type', 'application/json');
            $request = $request->withHeader('Accept', 'application/json');

            if(!empty($this->token)) {
                $request = $request->withHeader('Authorization', "Bearer {$this->token}");
            }

            return $request;
        }));

        return $stack;
    }
}
