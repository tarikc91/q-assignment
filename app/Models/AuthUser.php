<?php

namespace App\Models;

class AuthUser extends BaseModel
{
    public $id;
    public $email;
    public $firstName;
    public $lastName;
    public $gender;
    public $loggedIn = false;

    public function setLoggedIn(bool $value): void
    {
        $this->loggedIn = $value;
    }

    public function isLoggedIn(): bool
    {
        return $this->loggedIn;
    }
}
