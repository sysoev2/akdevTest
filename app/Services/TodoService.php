<?php

namespace App\Services;

use App\DTOs\TodoDTO;
use App\Models\Todo;

class TodoService
{
    public function store(TodoDTO $todoDTO): Todo
    {
        $todo = new Todo();
        $todo->title = $todoDTO->title;
        $todo->description = $todoDTO->description;
        $todo->complete = $todoDTO->complete;
        $todo->todoList()->associate($todoDTO->todo_list_id);
        $todo->save();
        return $todo;
    }

    public function update(Todo $todo,TodoDTO $todoDTO): Todo
    {
        $todo->update([
            'title' => $todoDTO->title,
            'description' => $todoDTO->description,
            'complete' => $todoDTO->complete,
        ]);

        return $todo;
    }

    public function delete(Todo $todo): bool
    {
        return $todo->delete();
    }
}
