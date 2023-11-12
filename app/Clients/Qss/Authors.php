<?php

namespace App\Clients\Qss;

use Psr\Http\Message\ResponseInterface;

class Authors extends Endpoint
{
    /**
     * Finds an author
     *
     * @param string $id
     * @return ResponseInterface
     */
    public function find(string $id): ResponseInterface
    {
        return $this->request('GET', "authors/{$id}");
    }

    /**
     * Gets all authors
     *
     * @param array $queryParams
     * @return ResponseInterface
     */
    public function all(array $queryParams = []): ResponseInterface
    {
        return $this->request('GET', 'authors', [], $queryParams);
    }

    /**
     * Creates an author
     *
     * @param array $body
     * @return ResponseInterface
     */
    public function create(array $body): ResponseInterface
    {
        return $this->request('POST', 'authors', [], $body);
    }

    /**
     * Deletes an author
     *
     * @param string $id
     * @return ResponseInterface
     */
    public function delete(string $id): ResponseInterface
    {
        return $this->request('DELETE', "authors/{$id}");
    }
}
