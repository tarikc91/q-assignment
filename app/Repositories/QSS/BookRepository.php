<?php

namespace App\Repositories\QSS;

use App\Models\Book;
use App\Clients\Qss\Client as QssClient;
use App\Transformers\Qss\BookTransformer as QssBookTransformer;
use App\Clients\Qss\Exceptions\RequestException as QssRequestException;
use App\Repositories\Contracts\BookRepository as BookRepositoryInterface;
use App\Clients\Qss\Exceptions\ModelNotFoundException as QssModelNotFoundException;

class BookRepository implements BookRepositoryInterface
{
    public function __construct(protected QssClient $client) {}

    public function create(array $body): Book
    {
        try {
            $response = $this->client->createBook($body);
            $item = json_decode($response->getBody(), true);

            return Book::createFromTransformer(new QssBookTransformer($item));
        } catch(QssRequestException $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    public function delete(mixed $id): bool
    {
        try {
            $this->client->deleteBook($id);
            return true;
        } catch(QssModelNotFoundException) {
            return false;
        } catch(QssRequestException $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }
}
