<?php

namespace App\Repositories\QSS;

use App\Models\Book;
use App\Clients\Qss\Client as QssClient;
use App\Transformers\Qss\BookTransformer as QssBookTransformer;
use App\Repositories\Contracts\BookRepository as BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    /**
     * constructor
     *
     * @param QssClient $client
     */
    public function __construct(protected QssClient $client) {}

    /**
     * Creates a book
     *
     * @param array $body
     * @return Book
     */
    public function create(array $body): Book
    {
        $response = $this->client->createBook($body);
        $item = json_decode($response->getBody(), true);

        return Book::createFromTransformer(new QssBookTransformer($item));
    }

    /**
     * Deletes a book by id
     *
     * @param string $id
     * @return boolean
     */
    public function delete(string $id): bool
    {
        return (bool) $this->client->deleteBook($id);
    }
}
