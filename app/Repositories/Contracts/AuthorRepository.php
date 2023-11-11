<?php

namespace App\Repositories\Contracts;

use App\Models\Author;

interface AuthorRepository
{
    /**
     * Gets all authors
     *
     * @return array
     */
    public function all(): array;

    /**
     * Finds an author
     *
     * @param string $id
     * @return Author|null
     */
    public function find(string $id): ?Author;

    /**
     * Deletes an author
     *
     * @param string $id
     * @return boolean
     */
    public function delete(string $id): bool;
}
