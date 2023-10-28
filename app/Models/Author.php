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
}
