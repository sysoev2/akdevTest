<?php

namespace Tests\Feature;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TodoListTest extends TestCase
{

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->hasAttached(TodoList::factory()->count(3), ['is_author'=> true])->create();
        $this->withHeader('Authorization', 'Bearer ' . $this->user->createApiToken());
    }

    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $response = $this->get(route('todoList.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'result' =>
                    [
                        '*' => [
                            'id',
                            'title',
                            'created_at',
                            'updated_at'
                        ]
                    ]
            ]
        );
    }

    public function test_show()
    {
        $response = $this->get(route('todoList.show', ['todoList' => $this->user->todoLists->first()->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'result' => [
                    'id',
                    'title',
                    'created_at',
                    'updated_at'
                ]
            ]
        );
    }

    public function test_store()
    {
        $todoList = TodoList::factory()->makeOne();
        $response = $this->post(route('todoList.store'), [
            'title' => $todoList->title
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'result' => [
                    'id',
                    'title',
                    'created_at',
                    'updated_at'
                ]
            ]
        );
        $response->assertJson([
            'result' => [
                'title' => $todoList->title
            ]
        ]);
    }

    public function test_show_todos()
    {
        $response = $this->get(route('todoList.showTodos', ['todoList' => $this->user->todoLists->first()->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'result' =>
                    [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'complete'
                        ]
                    ]
            ]
        );
    }

    public function test_export_PDF()
    {
        $response = $this->get(route('todoList.exportPDF', ['todoList' => $this->user->todoLists->first()->id]));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $response = $this->put(route('todoList.update', ['todoList' => $this->user->todoLists->first()->id]), ['title' => 'test']);
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'result' => [
                    'id',
                    'title',
                    'created_at',
                    'updated_at'
                ]
            ]
        );
        $response->assertJson([
            'result' => [
                'title' => 'test'
            ]
        ]);
    }

    public function test_destroy()
    {
        $response = $this->delete(route('todoList.destroy', ['todoList' => $this->user->todoLists->first()->id]));
        $response->assertStatus(200);

    }
}
