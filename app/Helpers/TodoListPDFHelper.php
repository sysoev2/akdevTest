<?php

namespace App\Helpers;

use App\Models\TodoList;
use Barryvdh\DomPDF\Facade\Pdf;

class TodoListPDFHelper
{
    public static function generateTodoListPDF(TodoList $todoList): string
    {
        $pdf = PDF::loadView('todos.index', ['todoList' => $todoList])->output();
        return $pdf;
    }
}
