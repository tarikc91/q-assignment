<?php

namespace App\Repositories\QSS;

use App\Models\Book;
use App\Clients\Qss\Qss;
use App\Clients\Qss\Books;
use App\Transformers\Qss\BookTransformer as QssBookTransformer;
use App\Repositories\Contracts\BookRepository as BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    /**
     * @var Books
     */
    protected Books $books;

    /**
     * constructor
     *
     * @param Qss $client
     */
    public function __construct(Qss $qss)
    {
        $this->books = $qss->books();
    }

    /**
     * Creates a book
     *
     * @param array $body
     * @return Book
     */
    public function create(array $body): Book
    {
        $response = $this->books->create($body);
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
        return (bool) $this->books->delete($id);
    }
}
