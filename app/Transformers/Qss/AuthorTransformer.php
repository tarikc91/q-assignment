<?php

namespace App\Transformers\Qss;

use DateTime;
use App\Models\Book;
use App\Transformers\Contracts\Transformer;
use App\Transformers\Qss\BookTransformer as QssBookTransformer;

class AuthorTransformer implements Transformer
{
    public function __construct(protected array $data){}

    public function transform(): array
    {
        $data = [
            'id' => $this->data['id'] ?? null,
            'firstName' => $this->data['first_name'] ?? null,
            'lastName' => $this->data['last_name'] ?? null,
            'birthday' => ($this->data['birthday'] ?? null) ? new DateTime($this->data['birthday']) : null,
            'gender' => $this->data['gender'] ?? null,
            'biography' => $this->data['biography'] ?? null,
            'placeOfBirth' => $this->data['place_of_birth'] ?? null,
            'books' => null
        ];

        if(isset($this->data['books'])) {
            $data['books'] = [];

            foreach($this->data['books'] as $bookData) {
                $data['books'][] = Book::createFromTransformer(new QssBookTransformer($bookData));
            }
        }

        return $data;
    }
}