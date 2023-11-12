<?php

namespace App\Repositories\QSS;

use App\Models\Author;
use App\Clients\Qss\Qss;
use App\Clients\Qss\Authors;
use App\Transformers\Qss\AuthorTransformer as QssAuthorTransformer;
use App\Repositories\Contracts\AuthorRepository as AuthorRepositoryInterface;

class AuthorRepository implements AuthorRepositoryInterface
{
    /**
     * @var Authors
     */
    protected Authors $authors;

    /**
     * Constructor
     *
     * @param Qss $qss
     */
    public function __construct(Qss $qss)
    {
        $this->authors = $qss->authors();
    }

    /**
     * Returns all authors
     *
     * @return array
     */
    public function all(): array
    {
        $response = $this->authors->all();
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
        $response = $this->authors->find($id);
        $item = json_decode($response->getBody(), true);

        return Author::createFromTransformer(new QssAuthorTransformer($item));
    }

    /**
     * Creates an author
     *
     * @param array $body
     * @return Author
     */
    public function create(array $body): Author
    {
        $response = $this->authors->create($body);
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
        return (bool) $this->authors->delete($id);
    }
}
