<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->hasAttached(TodoList::factory()->count(3)->has(Todo::factory()->count(3)), ['is_author'=> true])->create();
        $this->withHeader('Authorization', 'Bearer ' . $this->user->createApiToken());
    }
    /**
     * A basic feature test example.
     */
    public function test_show(): void
    {
        $response = $this->get(route('todo.show', [$this->user->todoLists->first()->todos->first()->id]));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'result' => [
                'id',
                'title',
                'description',
                'complete'
            ]
        ]);
    }

    public function test_store(): void
    {
        $todo = Todo::factory()->makeOne();

        $data = [
            'title' => $todo->title,
            'description' => $todo->description,
            'complete' => $todo->complete,
            'todo_list_id' => $this->user->todoLists->first()->id
        ];
        $response = $this->post(route('todo.store'), $data);

        $response->assertStatus(200);

        $response->assertJson([
            'result' => $data
        ]);
    }

    public function test_update(): void
    {
        $todo = Todo::factory()->makeOne();

        $data = [
            'title' => $todo->title,
            'description' => $todo->description,
            'complete' => $todo->complete,
        ];
        $response = $this->put(route('todo.update', [$this->user->todoLists->first()->todos->first()->id]), $data);

        $response->assertStatus(200);

        $response->assertJson([
            'result' => $data
        ]);
    }

    public function test_delete(): void
    {
        $response = $this->delete(route('todo.destroy', [$this->user->todoLists->first()->todos->first()->id]));

        $response->assertStatus(200);

    }
}
