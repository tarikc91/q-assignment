<?php

namespace App\Repositories\QSS;

use App\Models\Book;
use App\Clients\Qss\Client as QssClient;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Transformers\Qss\BookTransformer as QssBookTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repositories\Contracts\BookRepository as BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    public function __construct(protected QssClient $client) {}

    public function create(array $body): Book
    {
        try {
            $response = $this->client->createBook($body);
            $item = json_decode($response->getBody(), true);

            return Book::createFromTransformer(new QssBookTransformer($item));
        } catch(HttpException $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    public function delete(mixed $id): bool
    {
        try {
            $this->client->deleteBook($id);
            return true;
        } catch(NotFoundHttpException) {
            return false;
        } catch(HttpException $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }
}
