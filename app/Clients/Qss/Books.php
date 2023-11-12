<?php

namespace App\Clients\Qss;

use Psr\Http\Message\ResponseInterface;

class Books extends Endpoint
{
    /**
     * Creates a book
     *
     * @param array $body
     * @return ResponseInterface
     */
    public function create(array $body): ResponseInterface
    {
        return $this->request('POST', 'books', [], $body);
    }

    /**
     * Deletes a book
     *
     * @param string $id
     * @return ResponseInterface
     */
    public function delete(string $id): ResponseInterface
    {
        return $this->request('DELETE', "books/{$id}");
    }
}
