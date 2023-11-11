<?php

namespace App\Clients\Qss;

use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Client
{
    private const BASE_PATH = 'https://symfony-skeleton.q-tests.com/api/v2/';

    protected $client;
    protected $token;

    public function __construct($token = null)
    {
        $this->token = $token;

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

        $this->client = new GuzzleClient([
            'base_uri' => self::BASE_PATH,
            'handler' => $stack
        ]);
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    private function request(string $method, string $path, array $queryParams = [], array $body = []): ResponseInterface
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
        } elseif($response->getStatusCode() === 404) {
            throw new NotFoundHttpException();
        } else {
            $message = json_decode($response->getBody(), true)['message'] ?? 'Something went wrong while making the request to QSS!';
            throw new HttpException($response->getStatusCode(), $message);
        }
    }

    public function getAccessToken(string $email, string $password): array
    {
        $body = [
            'email' => $email,
            'password' => $password
        ];

        $response = $this->request('POST', 'token', [], $body);

        $responseBody = json_decode($response->getBody(), true);

        return [
            'token' => $responseBody['token_key'],
            'user' => $responseBody['user']
        ];
    }

    public function getAuthors(array $queryParams = []): ResponseInterface
    {
        return $this->request('GET', 'authors', [], $queryParams);
    }

    public function getAuthor(mixed $id): ResponseInterface
    {
        return $this->request('GET', "authors/{$id}");
    }

    public function createBook(array $data): ResponseInterface
    {
        $body = [
            'author' => [
                'id' => $data['author_id'] ? (int) $data['author_id'] : null
            ],
            'title' => $data['title'] ?? null,
            'release_date' => $data['release_date'] ?? null,
            'description' => $data['description'] ?? null,
            'isbn' => $data['isbn'] ?? null,
            'format' => $data['format'] ?? null,
            'number_of_pages' => $data['number_of_pages'] ? (int) $data['number_of_pages'] : null
        ];

        $body = array_filter($body);

        return $this->request('POST', 'books', [], $body);
    }

    public function createAuthor(array $data): ResponseInterface
    {
        $body = [
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'birthday' => $data['birthday'] ?? null,
            'biography' => $data['biography'] ?? null,
            'gender' => $data['gender'] ?? null,
            'place_of_birth' => $data['place_of_birth'] ?? null
        ];

        $body = array_filter($body);

        return $this->request('POST', 'authors', [], $body);
    }

    public function deleteBook(mixed $id): ResponseInterface
    {
        return $this->request('DELETE', "books/{$id}");
    }

    public function deleteAuthor(mixed $id): ResponseInterface
    {
        return $this->request('DELETE', "authors/{$id}");
    }
}
