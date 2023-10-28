<?php

namespace App\Models;

class Book extends BaseModel
{   
    public $id;
    public $title;
    public $releaseDate;
    public $description;
    public $isbn;
    public $format;
    public $numberOfPages;
}
