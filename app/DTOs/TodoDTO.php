<?php

namespace App\DTOs;

readonly class TodoDTO
{
    public bool $complete;

    public function __construct
    (
        public string $title,
        public ?string $description,
        public ?int $todo_list_id,
        $complete = false
    )
    {
        $this->complete = $complete;
    }
}
