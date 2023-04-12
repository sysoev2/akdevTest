<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_todo_lists', 'todo_list_id','user_id')->withPivot('is_author');
    }
}
