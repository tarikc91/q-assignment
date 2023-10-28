<?php

namespace App\Models;

use App\Transformers\Contracts\Transformer;

class BaseModel
{
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    public static function createFromTransformer(Transformer $transformer): static
    {
        return new static($transformer->transform());
    }

    public function setDataFromTransformer(Transformer $transformer): void
    {
        $this->setAttributes($transformer->transform());
    }

    public function setAttributes($attributes): void
    {
        foreach($attributes as $key => $value) {
            if(property_exists(static::class, $key)) {
                $this->$key = $value;
            }
        }
    }
}
