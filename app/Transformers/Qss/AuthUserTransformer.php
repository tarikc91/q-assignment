<?php

namespace App\Transformers\Qss;

use App\Transformers\Contracts\Transformer;

class AuthUserTransformer implements Transformer
{
    public function __construct(protected array $data){}

    public function transform(): array
    {
        return [
            'id' => $this->data['id'] ?? null,
            'email' => $this->data['email'] ?? null,
            'firstName' => $this->data['first_name'] ?? null,
            'lastName' => $this->data['last_name'] ?? null,
            'gender' => $this->data['gender'] ?? null
        ];
    }
}