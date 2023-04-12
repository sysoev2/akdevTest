<?php

namespace App\DTOs;

readonly class TodoListDTO
{
    public function __construct(
        public string $title
    )
    {
    }
}
