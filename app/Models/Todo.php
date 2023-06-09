<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'complete'];

    public $timestamps = false;

    public function todoList(): BelongsTo
    {
        return $this->belongsTo(TodoList::class);
    }
}
