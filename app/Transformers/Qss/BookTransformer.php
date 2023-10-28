<?php

namespace App\Transformers\Qss;

use DateTime;
use App\Transformers\Contracts\Transformer;

class BookTransformer implements Transformer
{
    public function __construct(protected array $data){}

    public function transform(): array
    {
        return [
            'id' => $this->data['id'] ?? null,
            'title' => $this->data['title'] ?? null,
            'releaseDate' => ($this->data['release_date'] ?? null) ? new DateTime($this->data['release_date']) : null,
            'description' => $this->data['description'] ?? null,
            'isbn' => $this->data['isbn'] ?? null,
            'format' => $this->data['format'] ?? null,
            'numberOfPages' => $this->data['number_of_pages'] ?? null
        ];
    }
}