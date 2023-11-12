<?php

namespace App\Clients\Qss;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class Endpoint
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * Constructor
     *
     * @param string|null $token
     */
    public function __construct(string $token = null)
    {
        $this->client = new Client($token);
    }

    /**
     * Makes a request on the client
     *
     * @param string $method
     * @param string $path
     * @param array $queryParams
     * @param array $body
     * @return ResponseInterface
     */
    public function request(string $method, string $path, array $queryParams = [], array $body = []): ResponseInterface
    {
        $options = [];

        if (!empty($queryParams)) {
            $options['query'] = $queryParams;
        }

        if (!empty($body)) {
            $options['json'] = $body;
        }

        $response = $this->client->request($method, $path, $options);

        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            return $response;
        }

        if($response->getStatusCode() === 404) {
            throw new NotFoundHttpException();
        }

        $message = json_decode($response->getBody(), true)['message'] ?? 'Something went wrong while making the request to QSS!';
        throw new HttpException($response->getStatusCode(), $message);
    }
}
