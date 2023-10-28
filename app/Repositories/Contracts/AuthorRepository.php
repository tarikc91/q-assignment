<?php

namespace App\Repositories\Contracts;

use App\Models\Author;

interface AuthorRepository
{
    public function all(): array;
    public function find(mixed $id): ?Author;
    public function delete(mixed $id): bool;
}
