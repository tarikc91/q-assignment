<?php

namespace App\Repositories\Contracts;

use App\Models\Book;

interface BookRepository
{
    public function create(array $body): Book;
    public function delete(mixed $id): bool;
}
