<?php

namespace App\Policies;

use App\DTOs\TodoDTO;
use App\Models\Todo;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TodoPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Todo $todo): bool
    {
        return $todo->todoList->users()->where('users.id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, TodoDTO $todoDTO): bool
    {
        $todoList = TodoList::find($todoDTO->todo_list_id);
        if(is_null($todoList)) {
            return false;
        }
        return $todoList->users()->where('users.id', $user->id)->wherePivot('is_author', true)->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Todo $todo): bool
    {
        return $todo->todoList->users()->where('users.id', $user->id)->wherePivot('is_author', true)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Todo $todo): bool
    {
        return $todo->todoList->users()->where('users.id', $user->id)->wherePivot('is_author', true)->exists();
    }
}
