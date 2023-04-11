<?php

namespace App\DTOs;

readonly class UserDTO
{
    public function __construct
    (
        public ?string $name,
        public string $email,
        public string $password
    )
    {
    }
}
