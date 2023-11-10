<?php

namespace App\Models;

class Author extends BaseModel
{
    public $id;
    public $firstName;
    public $lastName;
    public $birthday;
    public $gender;
    public $biography;
    public $placeOfBirth;
    public $books;

    /**
     * Checks if the author complies with all the rules before it can be deleted
     *
     * @return boolean
     */
    public function eligibleForDelete(): bool
    {
        return empty($this->books);
    }
}
