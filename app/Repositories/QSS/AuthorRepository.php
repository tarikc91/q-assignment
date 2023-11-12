<?php

namespace App\Repositories\QSS;

use App\Models\Author;
use App\Clients\Qss\Client as QssClient;
use App\Transformers\Qss\AuthorTransformer as QssAuthorTransformer;
use App\Repositories\Contracts\AuthorRepository as AuthorRepositoryInterface;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function __construct(protected QssClient $client) {}

    /**
     * Returns all authors
     *
     * @return array
     */
    public function all(): array
    {
        $response = $this->client->getAuthors();
        $items = json_decode($response->getBody(), true)['items'];

        $authors = array_map(
            fn($item) => Author::createFromTransformer(new QssAuthorTransformer($item)), 
            $items
        );

        return $authors;
    }

    /**
     * Finds an author
     *
     * @param string $id
     * @return Author|null
     */
    public function find(string $id): ?Author
    {
        $response = $this->client->getAuthor($id);
        $item = json_decode($response->getBody(), true);

        return Author::createFromTransformer(new QssAuthorTransformer($item));
    }

    /**
     * Deletes an author
     *
     * @param string $id
     * @return boolean
     */
    public function delete(string $id): bool
    {
        return (bool) $this->client->deleteAuthor($id);
    }
}
