<?php

namespace App\Services;

use App\DTOs\TodoListDTO;
use App\Models\TodoList;
use Illuminate\Support\Facades\Auth;

class TodoListService
{
    public function store(TodoListDTO $dto): TodoList
    {
        /** @var TodoList $todoList*/
        $todoList = TodoList::create([
            'title' => $dto->title
        ]);

        $todoList->users()->attach(Auth::id(), ['is_author' => true]);

        return $todoList;
    }

    public function update(TodoList $todoList, TodoListDTO $dto): TodoList
    {
        $todoList->update([
            'title' => $dto->title
        ]);
        return $todoList;
    }

    public function delete(TodoList $todoList): bool
    {
        return $todoList->delete();
    }
}
