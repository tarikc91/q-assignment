<?php

namespace App\Repositories\Contracts;

use App\Models\Book;

interface BookRepository
{
    /**
     * Creates a book
     *
     * @param array $data
     * @return Book
     */
    public function create(array $data): Book;

    /**
     * Deletes a book
     *
     * @param string $id
     * @return boolean
     */
    public function delete(string $id): bool;
}
